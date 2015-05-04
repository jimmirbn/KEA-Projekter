package database;

import java.sql.ResultSet;
import java.sql.SQLException;

/**
 *
 * @author Jimmi
 */
public class dbtest {

    public static void main(String[] args) {

        // EXECUTE A QUERY
        System.out.println("Creating statement...");
        String sql = "SELECT * FROM system_users";
        ResultSet rs = dbhandler.doQuery(sql);
        try {
            // Extract data from result set
            while (rs.next()) {
                int id = rs.getInt("id");
                String username = rs.getString("username");
                String password = rs.getString("password");
                System.out.println(
                        "Id: " + id + "\t\t"
                        + "Username: " + username + "\t\t"
                        + "Password: " + password + "\t\t"
                );
            }
        } catch (SQLException ex) {
            System.out.println(dbtest.class.getName() + "\n" + ex);
        }
        dbhandler.closeConnection();
        System.out.println("Goodbye");
    }
}
