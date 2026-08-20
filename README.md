# tennis-game

A CLI tennis game: a single, randomly-simulated "game" between two fictional players, rendered
live in your terminal as an ANSI-animated court.

## Overview

Each turn, a point is awarded to a random player, and the game state (love, 15, 30, 40, deuce,
advantage, win) is recomputed and redrawn. The terminal is cleared and repainted on every point
until one player wins the game, giving you a small live-updating scoreboard and ASCII court.

## Requirements

- Docker and Docker Compose

Everything else (PHP 8.5, dependencies) runs inside the container — no local PHP install needed.

## Commands

| Command      | What it does                                                                  |
|--------------|--------------------------------------------------------------------------------|
| `make up`    | Build and start the container, then run `composer install`                    |
| `make start` | Run the game (`php bin/console tennis-game:start`)                            |
| `make tests` | Run the PHPUnit test suite                                                     |
| `make check` | Verify formatting, lint, architecture guard and static analysis (Mago)        |
| `make fix`   | Auto-fix formatting, lint and safe static-analysis issues (Mago)              |
| `make sh`    | Open a shell in the container                                                  |
| `make down`  | Stop the container                                                             |

Each step of `make check` is also available on its own — `make fmt-check`, `make lint`,
`make guard`, `make analyze` — which is how CI runs them, one step per tool.

Get started:

```sh
make up
make start
```

## Architecture

The codebase is organized in four layers, each only allowed to depend on the ones before it:

```
Domain → Application → Interface → Infrastructure
```

- **`App\Domain`** — pure game logic, with no framework or I/O dependency whatsoever. `Game`
  plays a list of points through a state machine (`GameState`): `Points` (the normal love/15/30/40
  score) transitions to `Deuce`/`Advantage` once both players reach 40, and finally to `Win`.
  `Player` and `Point` are simple enums.
- **`App\Application`** — reserved for use-case orchestration; not used yet.
- **`App\Interface`** — defines the contracts the outer layers depend on: `CourtDisplay`,
  `PointWinnerPicker`, `Sleeper`, plus the console entry point (`StartCommand`, wired to the
  `tennis-game:start` command).
- **`App\Infrastructure`** — concrete implementations of those contracts: `ConsoleCourtDisplay`
  (clears the screen, renders the court, sleeps between frames), `RandomPointWinnerPicker`
  (randomly picks the winner of each point) and `UsleepSleeper`. The console rendering itself is
  composed from small single-purpose classes — `CourtGrid` (borders and net), `PlayerFigures`
  (ASCII art players), `Scoreboard` (centered score line) and `ScreenClearer` (ANSI clear) —
  assembled by `CourtRenderer`.

This is dependency inversion in practice: `Interface` declares what it needs, `Infrastructure`
provides it, and `Domain` never knows either exists. Wiring happens through Symfony's DI
container (`config/services.php`), which aliases each interface to its implementation
(`CourtDisplay` → `ConsoleCourtDisplay`, `Sleeper` → `UsleepSleeper`,
`PointWinnerPicker` → `RandomPointWinnerPicker`) and autowires the rest by convention.

## Quality tooling

This project uses [Mago](https://github.com/carthage-software/mago), a single Rust binary that
formats, lints, type-checks and enforces architecture — configured in `mago.toml`.

The most interesting part is `mago guard`, which turns the layering above into an enforced rule
instead of a convention. `mago.toml` declares the four layers and, for each namespace, what it's
permitted to depend on:

```toml
[[guard.perimeter.rules]]
namespace = "App\\Domain"
permit = [
    "@layer:core",
]
```

`core` is defined as `@native` only — meaning `App\Domain` cannot import anything but native PHP.
If a change made `Game` depend on Symfony or on an `Infrastructure` class, `mago guard` — and
therefore `make check` — would fail. `App\Interface` and `App\Infrastructure` have their own
rules, permitting `Symfony\Component\Console\**` and `Symfony\**` respectively.

Tests are written with PHPUnit: `tests/Unit/Domain/GameTest.php` exercises the full state machine
(regular scores, deuce, advantage, and wins for either player) using PHPUnit's `TestWith`
data provider attribute.
