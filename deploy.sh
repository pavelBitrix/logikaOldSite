#!/usr/bin/env bash
# =============================================================================
# Deploy backend customizations to the production Bitrix server
#
# Usage:
#   ./backend/deploy.sh              # dry-run (shows what will change)
#   ./backend/deploy.sh --apply      # actually upload
#
# Requires: rsync (or sftp fallback), SSH key configured for SERVER_USER@SERVER_HOST
# =============================================================================

set -euo pipefail

SERVER_USER="logika1cma"
SERVER_HOST="vh204"
REMOTE_ROOT="~/public_html"
API_DOMAIN="api.logika1c.ru"
LOCAL_ROOT="$(cd "$(dirname "$0")" && pwd)"

DRY_RUN="--dry-run"
if [[ "${1:-}" == "--apply" ]]; then
  DRY_RUN=""
  echo ">>> APPLY MODE — files will be uploaded"
else
  echo ">>> DRY-RUN MODE — use --apply to actually deploy"
fi

echo ""
echo "Deploying: $LOCAL_ROOT → $SERVER_USER@$SERVER_HOST:$REMOTE_ROOT"
echo "API domain: https://$API_DOMAIN"
echo "-------------------------------------------------------------"

# Deploy local/ module
rsync -avz --checksum $DRY_RUN \
  --exclude ".gitkeep" \
  "$LOCAL_ROOT/local/modules/logika.api/" \
  "$SERVER_USER@$SERVER_HOST:$REMOTE_ROOT/local/modules/logika.api/"

# Deploy php_interface (MERGE — do not delete existing files)
rsync -avz --checksum $DRY_RUN \
  "$LOCAL_ROOT/local/php_interface/" \
  "$SERVER_USER@$SERVER_HOST:$REMOTE_ROOT/local/php_interface/"

# Deploy api.php entry point
rsync -avz --checksum $DRY_RUN \
  "$LOCAL_ROOT/api.php" \
  "$SERVER_USER@$SERVER_HOST:$REMOTE_ROOT/api.php"

echo ""
if [[ -z "$DRY_RUN" ]]; then
  echo "Done. Don't forget to install/update the module in Bitrix admin."
else
  echo "Dry-run complete. Run with --apply to upload."
fi
