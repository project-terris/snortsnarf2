package libs.ConfigReader;

import java.io.*;
import java.util.Properties;

/**
 * The configuration reader is a wrapper around the .configuration file and simplifies access to the file
 * @author Sean H
 */
public class ConfigReader
{
    private static String configFilePath;
    private static File propertiesFile;
    private static Properties properties;
    private static InputStream inputStream;

    public ConfigReader(){}

    public ConfigReader(String configFilePath) throws IOException
    {
        this.configFilePath = configFilePath;
        this.properties = new Properties();
        this.inputStream = null;
        this.propertiesFile = new File(this.configFilePath);

        if(!propertiesFile.exists())
        {
            throw new IOException("Properties file does not exist");
        }
        try
        {
            this.inputStream = new FileInputStream(propertiesFile);
        } catch (FileNotFoundException e)
        {
            throw new IOException("Failed create input stream on properties file");
        }
        try
        {
            properties.load(this.inputStream);
        } catch (IOException e)
        {
            throw new IOException("Failed to load input stream for properties file");
        }
    }

    private static boolean getBoolean(String propName) { return Boolean.valueOf(getProp(propName));}

    public static String getProp(String propName)
    {
        return properties.getProperty(propName);
    }

    public static int getIntProp(String propName)
    {
        return new Integer(properties.getProperty(propName));
    }

    public static boolean getDebug() {return new Boolean(getProp("Debug"));}

    public static int getBufferSize() {return getIntProp("BufferSize");}

    public static boolean getLogToShell() { return getBoolean("LogToShell"); }

    public static boolean getLogToShellVerbose() { return getBoolean("LogToShellVerbose");}

    public static boolean getLogToFileVeryVerbose() { return getBoolean("LogToFileVeryVeryVerbose");}

    public static String getLogFileName() { return getProp("LogFileName"); }
}
