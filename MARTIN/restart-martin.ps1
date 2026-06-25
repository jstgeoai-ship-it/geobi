$dir = Split-Path -Parent $MyInvocation.MyCommand.Path
Stop-Process -Name martin -Force -ErrorAction SilentlyContinue
Start-Sleep -Seconds 1
& "$dir\martin.exe" --config "$dir\config\martin.yaml"
