/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package admin;

import Monday.SystemUser;
import Monday.SystemUserHandler;
import database.dbhandler;
import java.io.IOException;
import java.io.PrintWriter;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;

/**
 *
 * @author Jimmi
 */
@WebServlet(name = "adminServlet", urlPatterns = {"/adminServlet"})
public class adminServlet extends HttpServlet {

    /**
     * Processes requests for both HTTP <code>GET</code> and <code>POST</code>
     * methods.
     *
     * @param request servlet request
     * @param response servlet response
     * @throws ServletException if a servlet-specific error occurs
     * @throws IOException if an I/O error occurs
     */
    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        response.setContentType("text/html;charset=UTF-8");
        try (PrintWriter out = response.getWriter()) {
            HttpSession session = request.getSession(true);

            String myOutput;
            myOutput = "";
            String myOutput2;
            myOutput2 = "";
            String myOutput3;
            myOutput3 = "";
            String accessName;
            accessName = "";

            switch (request.getParameter("command")) {
                case "newUser":
                    String NewUsername = request.getParameter("username");
                    String NewPassword = request.getParameter("password");
                    String NewEmail = request.getParameter("email");
                    String NewFirstname = request.getParameter("firstname");
                    String NewLastname = request.getParameter("lastname");
                    int access = Integer.parseInt(request.getParameter("access"));
                    String imgData = request.getParameter("data");
                    String imgName = request.getParameter("filename");

                    // CHECK IF THE NEW USERNAME ALREADY EXSISTS IN USERLIST
                    SystemUser su = SystemUserHandler.checkNewUser(NewUsername, NewPassword, NewEmail, NewFirstname, NewLastname, access, imgData, imgName);

                    if (su != null) {
                        myOutput = "New user created: " + NewUsername;
                    }
                    if (su == null) {
                        myOutput = "This username is already taken";
                    }
                    break;

                case "getUser":

                    ArrayList<SystemUser> au = SystemUserHandler.getAllSystemUsers();
                    for (int i = 0; i < au.size(); i++) {
                        myOutput2 += "<tr><td>" + au.get(i).getId() + "</td><td id='username" + au.get(i).getId() + "'>" + au.get(i).getUsername() + "</td><td>" + au.get(i).getFirstName() + "</td><td>" + au.get(i).getLastName() + "</td><td>" + au.get(i).getEmail() + "</td><td><a class='getInputs' id='" + au.get(i).getId() + "'>Edit</a></td><td><a class='deleteU' id='" + au.get(i).getId() + "'>Delete</a></td></tr>";
                    }
                    break;
                case "getUserAdmin":

                    ArrayList<SystemUser> au2 = SystemUserHandler.getAllSystemUsers();
                    for (int i = 0; i < au2.size(); i++) {
                        if (au2.get(i).getAccess() == 1) {
                            accessName = "Content admin";
                        }
                        if (au2.get(i).getAccess() == 2) {
                            accessName = "User admin";
                        }
                        if (au2.get(i).getAccess() == 3) {
                            accessName = "Master admin";
                        }
                        if (au2.get(i).getAccess() == 4) {
                            accessName = "User & content admin";
                        }
                        if (au2.get(i).getAccess() == 5) {
                            accessName = "Standard user";
                        }
                        myOutput2 += "<tr><td>" + au2.get(i).getId() + "</td><td id='username" + au2.get(i).getId() + "'>" + au2.get(i).getUsername() + "</td><td>" + au2.get(i).getFirstName() + "</td><td>" + au2.get(i).getLastName() + "</td><td>" + au2.get(i).getEmail() + "</td><td><a class='getInputs' id='" + au2.get(i).getId() + "'>Edit</a></td><td><a class='deleteU' id='" + au2.get(i).getId() + "'>Delete</a></td><td>" + accessName + "</td><td><select id='" + au2.get(i).getId() + "' class='form-control permissionSelect' name='accesNr'><option>Choose permission</option><option value='1'>Content admin</option><option value='2'>User admin</option><option value='3'>Master admin</option><option value='4'>User & Content admin</option><option value='5'>Standard user</option></select</td></tr>";
                    }
                    break;

                case "deleteUser":
                    int id = Integer.parseInt(request.getParameter("id"));

                    SystemUserHandler.deleteUser(id);
                    break;

                case "getInputs":
                    int id2 = Integer.parseInt(request.getParameter("id"));
                    ArrayList<SystemUser> gi = SystemUserHandler.getAllSystemUsers();

                    for (int i = 0; i < gi.size(); i++) {
                        if (gi.get(i).getId() == id2) {

                            myOutput3 = "<div class='form-group'>Email: <input class='form-control' id='email+" + gi.get(i).getId() + "' type='text' value=" + gi.get(i).getEmail() + "></div>"
                                    + "<div class='form-group'>Firstname: <input class='form-control' id='firstname+" + gi.get(i).getId() + "' type='text' value=" + gi.get(i).getFirstName() + "></div>"
                                    + "<div class='form-group'>Lastname: <input class='form-control' id='lastname+" + gi.get(i).getId() + "' type='text' value=" + gi.get(i).getLastName() + "></div>"
                                    + "<button id='" + gi.get(i).getId() + "' class='updateUsers btn btn-info' type='button'>Edit user</button>";
                        }
                    }
                    break;
                case "editUser":

                    System.out.println("switch: edit user");
                    String email = request.getParameter("email");
                    String firstname = request.getParameter("firstname");
                    String lastname = request.getParameter("lastname");
                    int id3 = Integer.parseInt(request.getParameter("id"));

                    SystemUserHandler.editUser(id3, email, firstname, lastname);
                    break;

                case "createUser":
                    String NewUsername2 = request.getParameter("username");
                    String NewPassword2 = request.getParameter("password");
                    String NewEmail2 = request.getParameter("email");
                    String NewFirstname2 = request.getParameter("firstname");
                    String NewLastname2 = request.getParameter("lastname");
                    String imgData2 = request.getParameter("data");
                    String imgName2 = request.getParameter("filename");
                    int access2 = Integer.parseInt(request.getParameter("access"));

                    // CHECK IF THE NEW USERNAME ALREADY EXSISTS IN USERLIST
                    SystemUser su2 = SystemUserHandler.checkNewUser(NewUsername2, NewPassword2, NewEmail2, NewFirstname2, NewLastname2, access2, imgData2, imgName2);

                    if (su2 != null) {
                        myOutput = "1";
                    }
                    if (su2 == null) {
                        myOutput = "2";
                    }
                    break;
                case "changePermission":
                    int permission = Integer.parseInt(request.getParameter("permissionID"));
                    int userID = Integer.parseInt(request.getParameter("id"));
                    SystemUserHandler.changePermission(permission, userID);

                    break;
                case "editUserInfo":
                    String EditFirstname = request.getParameter("Firstname");
                    String EditLastname = request.getParameter("Lastname");
                    String EditEmail = request.getParameter("Email");
                    int editUserID = Integer.parseInt(request.getParameter("id"));

                    SystemUserHandler.EditUserInfo(editUserID, EditFirstname, EditLastname, EditEmail);
                        System.out.println("EDITUSERINFO!");
                    ArrayList<SystemUser> es = SystemUserHandler.getAllSystemUsers();
                            

                    for (int i = 0; i < es.size(); i++) {
                        if (es.get(i).getId() == editUserID) {
                            session.setAttribute("firstName", es.get(i).getFirstName());
                            session.setAttribute("lastName", es.get(i).getLastName());
                            session.setAttribute("email", es.get(i).getEmail());
                        }
                    }
                    break;
            }

            out.println(myOutput);
            out.println(myOutput2);
            out.println(myOutput3);

            out.close();

        }
    }

    // <editor-fold defaultstate="collapsed" desc="HttpServlet methods. Click on the + sign on the left to edit the code.">
    /**
     * Handles the HTTP <code>GET</code> method.
     *
     * @param request servlet request
     * @param response servlet response
     * @throws ServletException if a servlet-specific error occurs
     * @throws IOException if an I/O error occurs
     */
    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        processRequest(request, response);
    }

    /**
     * Handles the HTTP <code>POST</code> method.
     *
     * @param request servlet request
     * @param response servlet response
     * @throws ServletException if a servlet-specific error occurs
     * @throws IOException if an I/O error occurs
     */
    @Override
    protected void doPost(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        processRequest(request, response);
    }

    /**
     * Returns a short description of the servlet.
     *
     * @return a String containing servlet description
     */
    @Override
    public String getServletInfo() {
        return "Short description";
    }// </editor-fold>

}
