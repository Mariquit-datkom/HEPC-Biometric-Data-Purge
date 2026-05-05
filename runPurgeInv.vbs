Set shell = CreateObject("WScript.Shell")
Set fso = CreateObject("Scripting.FileSystemObject")

currentDir = fso.GetParentFolderName(WScript.ScriptFullName)

batchFile = currentDir & "\purgeCheck.bat"

shell.Run Chr(34) & batchFile & Chr(34), 0, True