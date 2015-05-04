/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package gadgets;

import Monday.SystemUser;
import Monday.SystemUserHandler;
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
public class SystemGadgetHandler {

    public static ArrayList<SystemGadget> getAllSubjects(String type) {
        ArrayList<SystemGadget> sg = new ArrayList<SystemGadget>();
        ResultSet rs = dbhandler.doQuery("SELECT *, date(SubjectDate),(SELECT COUNT(*)FROM comment WHERE comment.subject_id = edi_cms_fall2014.subjects.id) as countComment FROM subjects where typeGadget = '" + type + "'");
        try {
            if (rs.isBeforeFirst()) {
                while (rs.next()) {
                    sg.add(new SystemGadget(rs.getString("hovedemne"), Integer.parseInt(rs.getString("id")), type, rs.getString("user"), rs.getString("date(SubjectDate)"), Integer.parseInt(rs.getString("countComment"))));
                }
            }
        } catch (SQLException ex) {
            System.out.println(SystemGadgetHandler.class.getName() + "\n" + ex);
        }
        return sg;
    }

    public static ArrayList<SystemGadget> getAllCategories() {
        ArrayList<SystemGadget> gc = new ArrayList<SystemGadget>();
        ResultSet rs = dbhandler.doQuery("SELECT * from categories");
        try {
            if (rs.isBeforeFirst()) {
                while (rs.next()) {
                    gc.add(new SystemGadget(Integer.parseInt(rs.getString("id")), rs.getString("categoryName"), rs.getString("icon")));
                }
            }
        } catch (SQLException ex) {
            System.out.println(SystemGadgetHandler.class.getName() + "\n" + ex);
        }
        return gc;
    }

    public static ArrayList<SystemGadget> getComment(int id) {
        ArrayList<SystemGadget> sg2 = new ArrayList<SystemGadget>();
        ResultSet rs = dbhandler.doQuery("select * from comment where subject_id = '" + id + "'");
        try {
            if (rs.isBeforeFirst()) {
                while (rs.next()) {
                    sg2.add(new SystemGadget(rs.getString("commentTime"), rs.getString("comment"), rs.getString("user"), Integer.parseInt(rs.getString("subject_id")), Integer.parseInt(rs.getString("id"))));
                }
            }
        } catch (SQLException ex) {
            System.out.println(SystemGadgetHandler.class.getName() + "\n" + ex);
        }
        return sg2;
    }

    public static ArrayList<SystemGadget> getSubject(int id) {
        System.out.println(id);

        ArrayList<SystemGadget> sg3 = new ArrayList<SystemGadget>();
        ResultSet rs = dbhandler.doQuery("SELECT * FROM subjects "
                + "WHERE "
                + "id = '" + id + "'");
        try {
            if (rs.isBeforeFirst()) {
                while (rs.next()) {
                    sg3.add(new SystemGadget(rs.getString("hovedemne"), id, rs.getString("typeGadget"), rs.getString("user")));
                }
            }
        } catch (SQLException ex) {
            System.out.println(SystemGadgetHandler.class.getName() + "\n" + ex);
        }
        return sg3;
    }

    public static SystemGadget CreateSubject(String Subject, String GadgetType, String userName) {
        dbhandler.doUpdate("INSERT INTO subjects (hovedemne, typeGadget, user) values ('" + Subject + "', '" + GadgetType + "','" + userName + "')");
        return new SystemGadget(Subject, GadgetType, userName);
    }

    public static SystemGadget CreateComment(String Comment, String userName2, int subID, int userid) {
        dbhandler.doUpdate("INSERT INTO comment (user, comment, subject_id) values ('" + userName2 + "', '" + Comment + "','" + subID + "')");
        dbhandler.doUpdate("UPDATE system_users set points = points + 1 WHERE id = " + userid + "");
        return new SystemGadget(userName2, Comment, subID, userid);
    }

    public static SystemGadget DeleteComment(int id3) {
        dbhandler.doUpdate("DELETE FROM comment WHERE id = " + id3 + " ");
        return new SystemGadget(id3);
    }

    public static SystemGadget createCategory(String categoryName, String categoryIcon) {
        dbhandler.doUpdate("INSERT INTO categories (categoryName, icon) values ('" + categoryName + "', '" + categoryIcon + "')");
        return new SystemGadget(categoryName, categoryIcon);
    }
}
