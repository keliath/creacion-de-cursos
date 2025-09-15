param(
  [Parameter(Position=0)] [string]$Task = "",
  [string]$EnvFile = ".env"
)

function Compose() { param([string[]]$Args) docker compose @Args }

switch ($Task) {
  "build"      { Compose @('-f','docker-compose.yml','--env-file',$EnvFile,'build'); break }
  "up"         { Compose @('-f','docker-compose.yml','--env-file',$EnvFile,'up','-d'); break }
  "down"       { Compose @('-f','docker-compose.yml','--env-file',$EnvFile,'down'); break }
  "restart"    { Compose @('-f','docker-compose.yml','--env-file',$EnvFile,'restart'); break }
  "logs"       { Compose @('-f','docker-compose.yml','--env-file',$EnvFile,'logs','-f','--tail=200'); break }
  "ps"         { Compose @('-f','docker-compose.yml','--env-file',$EnvFile,'ps'); break }
  "shell"      { Compose @('-f','docker-compose.yml','--env-file',$EnvFile,'exec','app','sh'); break }
  "web-shell"  { Compose @('-f','docker-compose.yml','--env-file',$EnvFile,'exec','web','sh'); break }
  "db-shell"   { Compose @('-f','docker-compose.yml','--env-file',$EnvFile,'exec','db','bash','-lc','mariadb -uroot -p$env:DB_ROOT_PASSWORD $env:DB_NAME'); break }
  "migrate"    { Write-Output "Initial schema auto-applied from u170679010_fpptu.sql on first run."; break }
  "seed"       { Write-Output "Add seed SQL under docker/mysql/init and mount them if needed."; break }
  "smoke"      {
                  $port = (Get-Content $EnvFile | Where-Object { $_ -like 'APP_PORT=*' }) -replace 'APP_PORT=',''
                  for ($i=0; $i -lt 30; $i++) {
                    try { $res = Invoke-WebRequest -UseBasicParsing -Uri "http://localhost:$port/health" -TimeoutSec 2; if ($res.StatusCode -eq 200) { Write-Output "OK"; exit 0 } } catch {}
                    Start-Sleep -Seconds 1
                  }
                  Write-Error "Smoke test failed"; exit 1
                  break
                }
  "prod-build" { Compose @('-f','docker-compose.prod.yml','--env-file',$EnvFile,'build'); break }
  "prod-up"    { Compose @('-f','docker-compose.prod.yml','--env-file',$EnvFile,'up','-d'); break }
  "prod-down"  { Compose @('-f','docker-compose.prod.yml','--env-file',$EnvFile,'down'); break }
  default      { Write-Output "Usage: .\\make.ps1 [build|up|down|restart|logs|ps|shell|web-shell|db-shell|migrate|seed|smoke|prod-build|prod-up|prod-down] [-EnvFile .env]" }
}
