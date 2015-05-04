/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Monday;

import database.dbhandler;
import database.dbtest;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.logging.Level;
import java.util.logging.Logger;

/**
 *
 * @author Jimmi
 */
public class SystemUserHandler {

    private static ArrayList<SystemUser> loggedInsystemUsers = new ArrayList<>();

    public static void addSystemUser(SystemUser su) {
        loggedInsystemUsers.add(su);
    }

    public static ArrayList<SystemUser> getAllSystemUsers() {

        ArrayList<SystemUser> allSystemUsers = new ArrayList<>();

        String sql = "SELECT * FROM system_users";
        ResultSet rs = dbhandler.doQuery(sql);
        try {
            // Extract data from result set
            while (rs.next()) {
                int id = rs.getInt("id");
                String username = rs.getString("username");
                String password = rs.getString("password");
                String email = rs.getString("email");
                String firstname = rs.getString("firstname");
                String lastname = rs.getString("lastname");
                int access = rs.getInt("access");
                int points = rs.getInt("points");
                String img = rs.getString("imgData");
                SystemUser su = new SystemUser(id, username, password, email, firstname, lastname, access, points, img);
                allSystemUsers.add(su);
            }
        } catch (SQLException ex) {
            System.out.println(dbtest.class.getName() + "\n" + ex);
        }
        dbhandler.closeConnection();
        return allSystemUsers;
    }

    public static ArrayList<SystemUser> checkLogin(String username, String password) {

        ArrayList<SystemUser> su = new ArrayList<SystemUser>();
        ResultSet rs = dbhandler.doQuery("SELECT * FROM system_users "
                + "WHERE "
                + "username = '" + username + "' AND "
                + "password = '" + password + "'");
        try {
            if (rs.isBeforeFirst()) {
                while (rs.next()) {

                    su.add(new SystemUser(rs.getInt("id"), username, password, rs.getString("email"), rs.getString("firstname"), rs.getString("lastname"), rs.getInt("access"), rs.getInt("points"), rs.getString("imgData"), true));
//                    SystemUserHandler.getUsersPermissions(su);
                }
            }
        } catch (SQLException ex) {
            System.out.println(SystemUserHandler.class.getName() + "\n" + ex);
        }
        return su;
//        if (su != null) {
//            addSystemUser(su);
//        }

    }

    public static SystemUser checkNewUser(String username, String password, String email, String firstname, String lastname, int access, String imgData, String imgName) {
        
                    System.out.println("username: "+ username);

        SystemUser su = null;
        ResultSet rs = dbhandler.doQuery("SELECT * FROM system_users "
                + "WHERE "
                + "username = '" + username + "'");
        try {
            if (rs.isBeforeFirst()) {
                while (rs.next()) {

                }
            } else {
                su = SystemUserHandler.createNewUser(username, password, email, firstname, lastname, access, imgData, imgName);

            }
        } catch (SQLException ex) {
            System.out.println(SystemUserHandler.class.getName() + "\n" + ex);
        }
        return su;
    }

    public static SystemUser createNewUser(String username, String password, String email, String firstname, String lastname, int access, String imgData, String imgName) {
//        System.out.println("imgDATA"+ imgData);
        dbhandler.doUpdate("INSERT INTO system_users (username, password, email, firstname, lastname, access, imgData, imgName) values ('" + username + "', '" + password + "','" + email + "','" + firstname + "','" + lastname + "','" + access + "','" + imgData + "','" + imgName + "')");
        return new SystemUser(username, password, email, firstname, lastname, access, imgData, imgName);
    }

    public static void editUser(int editID, String email, String firstname, String lastname) {
        System.out.println("delete id:" + editID);
        dbhandler.doUpdate("UPDATE system_users SET " + "email = '" + email + "', " + "firstname = '" + firstname + "'," + "lastname = '" + lastname + "'  " + "where id = " + editID);
    }

    public static void deleteUser(int id) {
        dbhandler.doUpdate("DELETE FROM system_users WHERE id = " + id + " ");
    }

    public static void changePermission(int permission, int userID) {
        System.out.println(permission + " " + userID);
        dbhandler.doUpdate("UPDATE system_users SET " + "access = '" + permission + "'" + "where id = " + userID);
    }

    public static SystemUser EditUserInfo(int editUserID, String EditFirstname, String EditLastname, String EditEmail) {
            dbhandler.doUpdate("UPDATE system_users SET " + "email = '" + EditEmail + "', " + "firstname = '" + EditFirstname + "'," + "lastname = '" + EditLastname + "'  " + "where id = " + editUserID);
            return new SystemUser(editUserID, EditFirstname, EditLastname, EditEmail);

    }
}
