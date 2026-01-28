# ODBC Drivers in Microsoft's Ubuntu 22.04 Repository

## Repository Information

**Repository URL:** `deb [arch=amd64,arm64,armhf]
 https://packages.microsoft.com/ubuntu/22.04/prod jammy main`

This repository contains various Microsoft packages for Ubuntu 22.04
 (Jammy Jellyfish), supporting multiple architectures: amd64 (x86_64),
 arm64 (ARM 64-bit), and armhf (ARM 32-bit hard float).

## ODBC Drivers

The repository contains two main ODBC driver packages for SQL Server:

### 1. Microsoft ODBC Driver 17 for SQL Server (`msodbcsql17`)

**Package Name:** `msodbcsql17`  
**Architecture Support:** amd64 only  
**Latest Version:** 17.10.6.1-1 (as of April 2024)

**Available Versions:**
- `msodbcsql17_17.10.1.1-1_amd64.deb` (743.4 KB)
- `msodbcsql17_17.10.2.1-1_amd64.deb` (744.5 KB)
- `msodbcsql17_17.10.4.1-1_amd64.deb` (744.6 KB)
- `msodbcsql17_17.10.5.1-1_amd64.deb` (749.1 KB)
- `msodbcsql17_17.10.6.1-1_amd64.deb` (746.3 KB) - Latest

**Key Features:**
- Supports SQL Server 2008 and later
- Production-ready driver
- Widely used in enterprise environments
- Limited to x86_64 architecture

**Installation:**
```bash
sudo ACCEPT_EULA=Y apt-get install -y msodbcsql17
```

### 2. Microsoft ODBC Driver 18 for SQL Server (`msodbcsql18`)

**Package Name:** `msodbcsql18`  
**Architecture Support:** amd64, arm64  
**Latest Version:** 18.5.1.1-1 (as of 2024)

**Available Versions (Sample):**
- `msodbcsql18_18.1.1.1-1_amd64.deb` (751.6 KB) / `_arm64.deb` (685.7 KB)
- `msodbcsql18_18.1.2.1-1_amd64.deb` (752.0 KB) / `_arm64.deb` (686.5 KB)
- `msodbcsql18_18.2.1.1-1_amd64.deb` (752.8 KB) / `_arm64.deb` (687.3 KB)
- `msodbcsql18_18.2.2.1-1_amd64.deb` (752.6 KB) / `_arm64.deb` (687.4 KB)
- `msodbcsql18_18.3.1.1-1_amd64.deb` (756.5 KB) / `_arm64.deb` (689.8 KB)
- `msodbcsql18_18.3.2.1-1_amd64.deb` (755.9 KB) / `_arm64.deb` (690.5 KB)
- `msodbcsql18_18.3.3.1-1_amd64.deb` (755.1 KB) / `_arm64.deb` (689.3 KB)
- `msodbcsql18_18.4.1.1-1_amd64.deb` (755.2 KB) / `_arm64.deb` (689.5 KB)
- `msodbcsql18_18.5.1.1-1_amd64.deb` / `_arm64.deb` - Latest

**Key Features:**
- Latest driver with modern security features
- TLS 1.2 and TLS 1.3 support
- Azure Active Directory authentication support
- Always Encrypted with secure enclaves support
- ARM64 support (great for Apple Silicon, Raspberry Pi, AWS Graviton)
- Supports SQL Server 2012 and later

**Installation:**
```bash
sudo ACCEPT_EULA=Y apt-get install -y msodbcsql18
```

## SQL Server Command-Line Tools

### mssql-tools (Legacy)

**Package Name:** `mssql-tools`  
**Size:** 210.7 KB  
**Tools Included:** `sqlcmd`, `bcp`

**Installation:**
```bash
sudo ACCEPT_EULA=Y apt-get install -y mssql-tools
echo 'export PATH="$PATH:/opt/mssql-tools/bin"' >> ~/.bashrc
source ~/.bashrc
```

### mssql-tools18 (Current)

**Package Name:** `mssql-tools18`  
**Latest Version:** 18.x  
**Tools Included:** `sqlcmd`, `bcp` (version 18)

**Installation:**
```bash
sudo ACCEPT_EULA=Y apt-get install -y mssql-tools18
echo 'export PATH="$PATH:/opt/mssql-tools18/bin"' >> ~/.bashrc
source ~/.bashrc
```

**Key Features:**
- Compatible with ODBC Driver 18
- Modern encryption support
- Updated utilities for SQL Server management

## Architecture Comparison

| Package | amd64 | arm64 | armhf |
|---------|-------|-------|-------|
| msodbcsql17 | ✅ | ❌ | ❌ |
| msodbcsql18 | ✅ | ✅ | ❌ |
| mssql-tools | ✅ | ✅ | ✅ |
| mssql-tools18 | ✅ | ✅ | ✅ |

## Other Notable Packages in the Repository

The Microsoft Ubuntu 22.04 repository contains many other packages beyond ODBC drivers:

### Container/Docker Tools
- **moby-engine** - Docker engine (22.1 MB)
- **moby-cli** - Docker CLI (12.5 MB)
- **moby-containerd** - Container runtime (25.4 MB, supports amd64, arm64, armhf)
- **moby-runc** - Container runtime (5.1 MB)
- **moby-compose** - Docker Compose (9.5 MB)
- **moby-buildx** - Docker build extensions (25.0 MB)

### Security & Identity
- **microsoft-identity-broker** - Identity broker (79.8 MB)
- **microsoft-identity-diagnostics** - Identity diagnostics (3.7 MB)
- **mdatp** - Microsoft Defender for Endpoint (120.3 MB)
- **mde-netfilter** - Network filtering (25.5 kB)

### Development Tools
- **msft-golang** - Microsoft's Go distribution (48.5 MB)
- **msopenjdk-11** - OpenJDK 11 (194.0 MB)
- **msopenjdk-17** - OpenJDK 17 (182.4 MB)
- **msopenjdk-21** - OpenJDK 21 (176.4 MB)
- **msopenjdk-25** - OpenJDK 25 (190.1 MB)

### .NET Tools
- **netstandard-targeting-pack-2.1** - .NET Standard targeting pack (1.5 MB)
- **aspnetcore-runtime** - ASP.NET Core runtime
- **dotnet-sdk** - .NET SDK

### Other Tools
- **microsoft-azurevpnclient** - Azure VPN client (12.6 MB)
- **msalsdk-dbusclient** - MSAL DBus client (9.3 kB)

## Complete Installation Guide

### Step 1: Add Microsoft Repository

```bash
# Download and install the Microsoft repository GPG key
curl https://packages.microsoft.com/keys/microsoft.asc | sudo tee /etc/apt/trusted.gpg.d/microsoft.asc

# Add the Microsoft repository
curl https://packages.microsoft.com/config/ubuntu/22.04/prod.list | sudo tee /etc/apt/sources.list.d/mssql-release.list

# Update package lists
sudo apt-get update
```

### Step 2: Install ODBC Driver 18 (Recommended)

```bash
# Install ODBC Driver 18
sudo ACCEPT_EULA=Y apt-get install -y msodbcsql18

# Optional: Install command-line tools
sudo ACCEPT_EULA=Y apt-get install -y mssql-tools18

# Optional: Install development headers
sudo apt-get install -y unixodbc-dev

# Add tools to PATH
echo 'export PATH="$PATH:/opt/mssql-tools18/bin"' >> ~/.bashrc
source ~/.bashrc
```

### Step 3: Verify Installation

```bash
# Check ODBC driver installation
odbcinst -q -d -n "ODBC Driver 18 for SQL Server"

# Test sqlcmd (if installed)
sqlcmd -?
```

## Version Selection Guide

### When to use ODBC Driver 17:
- Legacy applications requiring Driver 17
- Compatibility with older SQL Server versions
- Only need x86_64 support
- Existing deployments using Driver 17

### When to use ODBC Driver 18:
- New deployments (recommended)
- Need ARM64 support (Apple Silicon, AWS Graviton, etc.)
- Require latest security features (TLS 1.3)
- Azure Active Directory authentication
- Always Encrypted with secure enclaves
- Better performance and modern standards

## Connection String Examples

### Using ODBC Driver 17
```
Driver={ODBC Driver 17 for SQL Server};Server=myserver.database.windows.net;
Database=mydb;Uid=myuser;Pwd=mypassword;
```

### Using ODBC Driver 18
```
Driver={ODBC Driver 18 for SQL Server};Server=myserver.database.windows.net;
Database=mydb;Uid=myuser;Pwd=mypassword;Encrypt=yes;TrustServerCertificate=no;
```

**Important Note:** Driver 18 requires explicit encryption settings.
 Always include `Encrypt=yes` for secure connections.

## Dependencies

Both ODBC drivers require:
- **unixODBC** (>= 2.3.1) - ODBC Driver Manager
- **libc6** (>= 2.21)
- **libstdc++6** (>= 4.9)
- **libkrb5-3** - Kerberos authentication
- **openssl** - SSL/TLS support

These dependencies are usually automatically installed by `apt`.

## EULA Acceptance

All Microsoft ODBC packages require EULA acceptance. You can:

**Option 1:** Accept during installation
```bash
sudo ACCEPT_EULA=Y apt-get install -y msodbcsql18
```

**Option 2:** Pre-accept for automated deployments (Driver 18.4+)
```bash
sudo mkdir -p /opt/microsoft/msodbcsql18
sudo touch /opt/microsoft/msodbcsql18/ACCEPT_EULA
```

## Troubleshooting

### Common Issues

**Issue 1: Repository Not Found**
```bash
# Ensure the repository is properly added
cat /etc/apt/sources.list.d/mssql-release.list

# Should contain:
# deb [arch=amd64,arm64,armhf signed-by=/etc/apt/trusted.gpg.d/microsoft.asc]
 https://packages.microsoft.com/ubuntu/22.04/prod jammy main
```

**Issue 2: EULA Not Accepted**
```bash
# Error: "Package msodbcsql18 has no installation candidate"
# Solution: Set ACCEPT_EULA=Y environment variable
sudo ACCEPT_EULA=Y apt-get install -y msodbcsql18
```

**Issue 3: Missing Dependencies**
```bash
# Install unixODBC if missing
sudo apt-get install -y unixodbc unixodbc-dev
```

**Issue 4: Driver Not Found by Application**
```bash
# List installed drivers
odbcinst -q -d

# If driver not listed, check installation
dpkg -l | grep msodbcsql
```

## ARM64 Support

ODBC Driver 18 provides ARM64 support, making it suitable for:
- **Apple Silicon Macs** (M1, M2, M3, M4)
- **AWS Graviton** instances
- **Azure ARM-based VMs**
- **Raspberry Pi 4/5** (64-bit OS)
- **Oracle Cloud ARM instances**

Example ARM64 installation:
```bash
# On ARM64 Ubuntu 22.04
sudo ACCEPT_EULA=Y apt-get install -y msodbcsql18:arm64
```

## Security Considerations

1. **Always use encrypted connections** - Set `Encrypt=yes` in connection strings
2. **Validate certificates** - Use `TrustServerCertificate=no` in production
3. **Keep drivers updated** - Regularly update to latest versions for security patches
4. **Use strong authentication** - Implement Azure AD or certificate-based auth where possible
5. **Restrict network access** - Use firewalls and VPNs for database connections

## References

- [Microsoft ODBC Driver Documentation](https://learn.microsoft.com/en-us/sql/connect/odbc/)
- [Download ODBC Driver for SQL Server](https://learn.microsoft.com/en-us/sql/connect/odbc/download-odbc-driver-for-sql-server)
- [Installing the Linux Driver](https://learn.microsoft.com/en-us/sql/connect/odbc/linux-mac/installing-the-microsoft-odbc-driver-for-sql-server)
- [Release Notes](https://learn.microsoft.com/en-us/sql/connect/odbc/linux-mac/release-notes-odbc-sql-server-linux-mac)

## Summary

The Microsoft Ubuntu 22.04 repository (`packages.microsoft.com/ubuntu/22.04/prod`) contains:

**Primary ODBC Drivers:**
- **msodbcsql17** - Version 17.x (amd64 only)
- **msodbcsql18** - Version 18.x (amd64, arm64) - **Recommended**

**Command-Line Tools:**
- **mssql-tools** - Legacy tools
- **mssql-tools18** - Current tools (recommended)

**Additional Packages:**
- Container tools (Docker/Moby)
- Security tools (Defender, Identity)
- Development tools (Go, OpenJDK, .NET)
- Azure tools (VPN client)

For most use cases, **ODBC Driver 18 (`msodbcsql18`)** is the recommended choice
 due to its modern features, ARM64 support, and enhanced security capabilities.
