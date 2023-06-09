# CONTRIBUTING

Contributions are welcome, and are accepted via pull requests.
Please review these guidelines before submitting any pull requests.

## Process

1. Fork the project
2. Create a new branch
3. Code, test, commit and push
4. Open a pull request detailing your changes.

## Guidelines

* Please ensure the coding style running `composer refactor:lint`.
* Send a coherent commit history, making sure each individual commit in your pull request is meaningful.
* You may need to [rebase](https://git-scm.com/book/en/v2/Git-Branching-Rebasing) to avoid merge conflicts.
* Please remember that we follow [SemVer](http://semver.org/).

## Setup

Clone your fork, then install the dev dependencies:
```bash
composer install
```

## Refactor

Refactor your code:
```bash
composer refactor:rector
```

## Lint

Lint your code:
```bash
composer refactor:lint
```

## Tests

Run all tests:
```bash
composer test
```

Check code quality:
```bash
composer test:refactor
```

Check types:
```bash
composer test:types
```

Unit tests:
```bash
composer test:pest
```
