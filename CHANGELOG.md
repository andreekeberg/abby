# Changelog

All notable changes to this project will be documented in this file.

## [1.1.1] - 2020-05-20

### Changed

- Allow looser typing across all methods (casting all numeric strings to integers and floats internally)

## [1.1.0] - 2020-05-14

### Added

- Added [`User::hasViewed`](docs/User.md#userhasviewed)
- Added [`User::setViewed`](docs/User.md#usersetviewed)

### Breaking changes

- Updated [`User::addExperiment`](docs/User.md#useraddexperiment) to include a `$viewed` argument before `$converted`
- Renamed `Group::getSize` to [`Group::getViews`](docs/Group.md#groupgetviews)
- Renamed `Group::setSize` to [`Group::setViews`](docs/Group.md#groupsetviews)
- Renamed `Experiment::getCoverage` to [`Experiment::getAllocation`](docs/Experiment.md#experimentgetallocation)
- Renamed `Experiment::setCoverage` to [`Experiment::setAllocation`](docs/Experiment.md#experimentsetallocation)

## [1.0.0] - 2020-04-29

Initial release

[1.1.1]: https://github.com/andreekeberg/abby/releases/tag/1.1.1
[1.1.0]: https://github.com/andreekeberg/abby/releases/tag/1.1.0
[1.0.0]: https://github.com/andreekeberg/abby/releases/tag/1.0.0
