mkdir Party-Connect-Attendance-Plugin

xcopy "..\..\assets" "Party-Connect-Attendance-Plugin\assets\" /S /Y
xcopy "..\..\js" "Party-Connect-Attendance-Plugin\js\" /S /Y
xcopy "..\..\lang" "Party-Connect-Attendance-Plugin\lang\" /S /Y
xcopy "..\..\styles" "Party-Connect-Attendance-Plugin\styles\" /S /Y
xcopy "..\..\*.php" "Party-Connect-Attendance-Plugin\" /F /Y
xcopy "..\..\readme.*" "Party-Connect-Attendance-Plugin\" /F /Y
xcopy "..\..\LICENSE" "Party-Connect-Attendance-Plugin\" /F /Y

7z a Party-Connect-Attendance-Plugin.zip Party-Connect-Attendance-Plugin

rmdir "Party-Connect-Attendance-Plugin" /s /q

pause;
