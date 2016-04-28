package libs.Logger;

import java.io.File;
import java.io.IOException;
import java.io.PrintWriter;
import java.io.StringWriter;
import java.nio.ByteBuffer;

/**
 * This ia a logger file that will deal with logging data to a file or outputting to the shell and how verbose it is to
 * where
 * @author Sean Hodgkinson
 * @version 1.0
 */
public final class Logger
{

    public static final String ANSI_RED = "\u001B[31m"; //Prints red text to the shell
    public static final String ANSI_RESET = "\u001B[0m"; //Prints noraml text to the shell

    private static File logFile;
    private static boolean logToShell;
    private static boolean logToShellVerbose;
    private static boolean logToFile;
    private static PrintWriter logWriter;
    private static Logger instanceOf;

    /**
     * This sets up the logger and sets how verbose it should be with logging
     * @param logToShell            Log anything to shell
     * @param logToShellVerbose     Log everything to shell
     * @param logToFileVeryVerbose  Log everything to file
     * @param pathToLogFileString   Path to the log file
     */
    public Logger(boolean logToShell, boolean logToShellVerbose, boolean logToFileVeryVerbose, String pathToLogFileString)
    {
        logFile = null;
        logWriter = null;

        if(logToFileVeryVerbose == true) //If logging to file, check file
        {
            if(pathToLogFileString == null) //Check if file path is not null
            {
                shellLog("File path not given but log to file was set. Not logging to file.");
                logToFileVeryVerbose = false;
            }
            else //If file path was not null
            {
                logFile = new File(pathToLogFileString); //Create a file object
                if(!logFile.exists()) //If the file does not exists then it is created
                {
                    try { //Try to create the file
                        logFile.createNewFile();

                    } catch (IOException e) { //If it fails then logging is turned off
                        shellLog("Cannot create file for logging. Logging turned off");
                        logFile = null;
                        logWriter = null;
                        logToFileVeryVerbose = false;
                    }
                }

                try { //Creates the PrintWriter that will print out to the log files
                    logWriter = new PrintWriter(logFile.getPath());
                }
                catch (IOException e){
                    shellLog("Cannot create Log Writer, file logging turned off");
                }
            }
        }

        this.logToFile = logToFileVeryVerbose;
        this.logToShell = logToShell;
        this.logToShellVerbose = logToShellVerbose;

        this.instanceOf = this;
    }

    public Logger(){}

    /**
     * Outputs a string to the shell if shell logging is wanted
     * @param input
     */
    private static final void shellLog(String input)
    {
        if(logToShell == true)
            System.out.println(input);
    }

    /**
     * Outputs a string to the shell if shell logging is wanted with no newline
     * @param input
     */
    private static final void shellLogNoNewLine(String input)
    {
        if(logToShell == true)
            System.out.print(input);
    }

    /**
     * Outputs String to file if file logging is wanted
     * @param input
     */
    private static final void fileLog(String input)
    {
        if(logToFile == true)
        {
            logWriter.println(input);
            logWriter.flush();
        }
    }

    /**
     * Used to log to only the file not the terminal
     * @param input
     */
    public static final void fileOnlyLog(String input)
    {
        fileLog(input);
    }

    /**
     * Outputs String to file if file logging is wanted
     * @param input
     */
    private static final void fileLogNoNewLine(String input)
    {
        if(logToFile == true)
            logWriter.print(input);
    }

    /**
     * Basic log function that will log output given (for not verbose logging)
     * @param input
     */
    public static final void log(String input)
    {
        shellLog(input);
        fileLog(input);
    }

    /**
     * Basic log function that will log output given (for not verbose logging) with no newline
     * @param input
     */
    public static final void logNoNewLine(String input)
    {
        shellLogNoNewLine(input);
        fileLogNoNewLine(input);
    }

    /**
     * Basic logging for verbose logging, such a packet outputs
     * @param input
     */
    public static final void vLog(String input)
    {
        if(logToShellVerbose == true)
            shellLog(input);
        fileLog(input);
    }

    /**
     * Closes the log writer, flushing the buffer
     */
    public static final void close()
    {
        logWriter.close();
    }

    /**
     * Prints red text to the shell
     * @param input
     */
    public static final void error(String input)
    {
        shellLog(ANSI_RED + input + ANSI_RESET);
        fileLog(input);
    }

    /**
     * Logs an exception
     * @param e
     */
    public static void log(Exception e)
    {
        StringWriter sw = new StringWriter();
        PrintWriter pw = new PrintWriter(sw);
        e.printStackTrace(pw);
        error(sw.toString());
    }
}
