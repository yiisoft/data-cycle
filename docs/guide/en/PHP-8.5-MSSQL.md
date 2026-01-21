# PHP 8.5 Implications for MSSQL Workflow (AI Source: Claude Sonnet 4.5
 - free try )

## Executive Summary

**Do not add PHP 8.5 to the MSSQL workflow yet.** The current pdo_sqlsrv driver
 (version 5.12) does not support PHP 8.5, and the workflow will fail during
 PHP extension installation.

## Critical Blocker: Driver Incompatibility

### Current Situation

The pdo_sqlsrv 5.12.0 extension specified in the workflow does not compile
against PHP 8.5.0 due to internal PHP API changes. This means any attempt to
add PHP 8.5 to the test matrix will result in immediate workflow failures.

### Driver Support Status

| PHP Version | pdo_sqlsrv 5.12 Support |
|-------------|------------------------|
| 8.1         | ✅ Fully Supported     |
| 8.2         | ✅ Fully Supported     |
| 8.3         | ✅ Fully Supported     |
| 8.4         | ⚠️ Unofficial/Limited  |
| 8.5         | ❌ Not Supported       |

## What Needs to Happen First

Before PHP 8.5 can be added to the workflow:

1. **Microsoft must release a new pdo_sqlsrv driver version** (likely 5.13 or 6.0)
2. **The new driver must be available via PECL** for installation through
   shivammathur/setup-php
3. **The workflow's extension configuration must be updated** to reference the
   new driver version

## Timeline Expectations

Based on historical patterns with previous PHP releases:

- **Expected delay**: 2-6 months after PHP 8.5 official release
- **PHP 8.4 precedent**: As of late 2024/early 2025, PHP 8.4 still lacks full
    official MSSQL driver support
- **Recommendation**: Monitor the Microsoft msphpsql repository for announcements

## Recommended Action Plan

### Phase 1: Monitoring (Current)

Monitor these resources for updates:

- [Microsoft msphpsql GitHub](https://github.com/microsoft/msphpsql) - Official
    driver repository
- [PECL pdo_sqlsrv page](https://pecl.php.net/package/pdo_sqlsrv) - Release
    announcements
- PHP 8.5 release notes and compatibility matrices

### Phase 2: Early Testing (When Driver Available)

Once a compatible driver is released:

```yaml
strategy:
  matrix:
    php:
      - 8.1
      - 8.2
      - 8.3
      - 8.4
      - 8.5
```

Update the extensions configuration:

```yaml
env:
  extensions: pdo, pdo_sqlsrv-5.13  # Or whatever the new version is
```

Consider using `continue-on-error: true` initially for PHP 8.5 jobs:

```yaml
- name: Run tests with phpunit
  continue-on-error: ${{ matrix.php == '8.5' }}
  run: vendor/bin/phpunit --testsuite=Mssql --coverage-clover=coverage.xml
       --colors=always
```

### Phase 3: Full Integration

After confirming stability:

- Remove `continue-on-error` flag
- Make PHP 8.5 a required test in the CI pipeline

## Potential Failure Points

If you add PHP 8.5 prematurely, expect failures at:

1. **Extension Installation Step**
   ```
   shivammathur/setup-php@v2
   ```
   Error: Unable to install pdo_sqlsrv-5.12 for PHP 8.5

2. **Compilation Errors**
   The driver may attempt to compile but fail due to API incompatibilities

3. **Runtime Errors**
   Even if installation succeeds, runtime incompatibilities may cause test failures

## PHP 8.5 Features to Be Aware Of

While waiting for driver support, note these PHP 8.5 changes that could impact
  your codebase:

- **Pipe operator**: New functional programming syntax
- **Clone with syntax**: Enhanced object cloning
- **Deprecations**: Non-canonical scalar type casts
- **Other improvements**: Property hooks, asymmetric visibility

These changes are unlikely to directly affect database operations but may impact
  application code.

## Testing Strategy

When driver support becomes available:

1. **Create a separate test branch** with PHP 8.5 added to the matrix
2. **Run the full test suite** against all MSSQL versions (2017, 2019, 2022)
3. **Check for deprecation warnings** in test output
4. **Verify compatibility** with all PHP versions in the matrix
5. **Monitor for performance regressions**

## Current Workflow Status

The workflow currently tests:

- **PHP versions**: 8.1, 8.2, 8.3, 8.4
- **MSSQL versions**: 2017 (ODBC 17), 2019 (ODBC 18), 2022 (ODBC 18)
- **Driver version**: pdo_sqlsrv-5.12

This configuration is stable and should remain unchanged until driver
compatibility is confirmed.

## Conclusion

**Action Required**: None at this time. Continue monitoring for pdo_sqlsrv
driver updates.

**Do Not**: Add PHP 8.5 to the test matrix until Microsoft releases a compatible
driver version.

**Next Steps**: Watch the Microsoft msphpsql GitHub repository for release
announcements and update this document when new information becomes available.

---

**Last Updated**: 21st January 2026  
**Status**: Awaiting pdo_sqlsrv driver support for PHP 8.5

## Actions checkout can also be upgraded to version 6?

**What's New in v6**
Version 6 includes Node.js 24 support and persists credentials to a separate
file PHP, along with worktree support improvements.

**Upgrade Path**
You can upgrade safely from v3 → v4 → v5 → v6, or jump directly to v6. The
action maintains backwards compatibility for basic usage.

**Updated Workflow**
Here's your workflow with the checkout action upgraded to v6:

yaml- name: Checkout
  uses: actions/checkout@v4  # Can be upgraded to @v6

Should become:
yaml- name: Checkout
  uses: actions/checkout@v6

**Should You Upgrade?**
Yes, you should upgrade for several reasons:

**Security updates - Newer versions include security patches**
Node.js 24 support - Better performance and compatibility

**Bug fixes - Various improvements and stability enhancements**
Future-proofing - v3 is quite old and may eventually be deprecated

Migration Considerations
The upgrade from v3 to v6 should be seamless for your use case since you're
using the basic checkout without special parameters.

**However, it's good practice to:**

1. Test the workflow in a feature branch first
2. Review the changelog for any breaking changes
3. Consider pinning to a specific commit SHA for maximum stability in production
(e.g., actions/checkout@8e8c483db84b4bee98b60c0593521ed34d9990e8)

For your workflow, the simple version upgrade is perfectly fine and recommended!
Claude is AI and can make mistakes. Please double-check cited sources. 