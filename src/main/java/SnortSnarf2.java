import libs.ConfigReader.ConfigReader;
import libs.Logger.Logger;

import java.io.IOException;

public class SnortSnarf2
{
    public static void main(String[] args)
    {
        new Logger(true, true, true, "Logs/Log");
        try
        {
            new ConfigReader("Config.properties");
        } catch (IOException e)
        {
            Logger.error("Failed to find Config.properties file at root. Exiting");
            System.exit(1);
        }
        Logger.log("Debug running: " + ConfigReader.getDebug());
    }
}
