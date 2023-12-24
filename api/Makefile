.DEFAULT_GOAL := help

PHPUNIT := bin/phpunit
BEHAT := vendor/bin/behat
PHP_CS_FIXER := vendor/bin/php-cs-fixer
PHPSTAN := vendor/bin/phpstan

.PHONY: behat
behat: ## Run Behat tests.
	@$(BEHAT)

.PHONY: phpunit
phpunit: ## Run PHPUnit tests.
	@$(PHPUNIT)

.PHONY: test
test: phpunit behat ## Run all tests (PHPUnit and Behat).

.PHONY: cs-dry-run
cs-dry-run: ## Dry run of PHP-CS-Fixer, show what would be fixed but do not change files.
	@$(PHP_CS_FIXER) fix --dry-run --diff

.PHONY: cs-fix
cs-fix: ## Run PHP-CS-Fixer and fix coding standards issues.
	@$(PHP_CS_FIXER) fix

.PHONY: phpstan
phpstan: ## Run PHPStan for static analysis of PHP code.
	@$(PHPSTAN) analyse

.PHONY: lint
lint: cs-dry-run phpstan ## Perform linting (code style check and static analysis).

.PHONY: help
help: ## Show this help message.
	@echo "\033[33mUsage:\033[0m"
	@echo "  make <target>"
	@echo ""
	@echo "\033[33mTargets:\033[0m"
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z0-9_-]+:.*?## / {printf "  \033[36m%-15s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)
