package database;

import static database.dbinfo.DATABASE_PWD;
import static database.dbinfo.DATABASE_URL;
import static database.dbinfo.DATABASE_USR;
import static database.dbinfo.JDBC_DRIVER;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;

/**
 *
 * @author Jimmi
 */
public class dbhandler implements dbinfo {

    private static Connection conn = null;
    private static Statement stmt = null;

    public static ResultSet doQuery(String statement) {
        openConnection();
        ResultSet rs = null;
        try {
            stmt = conn.createStatement();
            rs = stmt.executeQuery(statement);
        } catch (SQLException ex) {
            System.out.println(dbhandler.class.getName() + "\n" + ex);
        }

        return rs;
    }
    
    public static void doUpdate(String statement) {
        openConnection();
        try {
            stmt = conn.createStatement();
            stmt.executeUpdate(statement);
        } catch (SQLException ex) {
            System.out.println(dbhandler.class.getName() + "\n" + ex);
        }
        closeConnection();
    }

    private static void openConnection() {

        // REGISTER WITH JDBC DRIVER - 
        try {
            Class.forName(JDBC_DRIVER);

            // OPEN A CONNECTION 
            System.out.println("Connecting to database..");
            conn = DriverManager.getConnection(DATABASE_URL, DATABASE_USR, DATABASE_PWD);

        } catch (ClassNotFoundException ex) {
            System.out.println(ex);
        } catch (SQLException ex) {
            System.out.println(dbhandler.class.getName() + "\n" + ex);
        }

    }

    public static void closeConnection() {
        try {
            stmt.close();
        } catch (SQLException e) {
            System.err.println(e);
        }
        try {

            conn.close();
        } catch (SQLException e) {
            System.out.println(e);
        }
    }
}
