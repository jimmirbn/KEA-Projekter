/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Monday;

import database.dbtest;
import flexjson.JSONSerializer;
import gadgets.SystemGadget;
import gadgets.SystemGadgetHandler;
import java.io.IOException;
import java.io.PrintWriter;
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
@WebServlet(name = "Servlet", urlPatterns = {"/Servlet"})
public class Servlet extends HttpServlet {

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
            /* TODO output your page here. You may use following sample code. */

            String myOutPut;
            myOutPut = "";
            String myOutPut2;
            myOutPut2 = "";
            String myOutPut4;
            myOutPut4 = "";

            switch (request.getParameter("type")) {
                case "login":
                    String username = request.getParameter("username");
                    String password = request.getParameter("password");
                    ArrayList<SystemUser> su = SystemUserHandler.checkLogin(username, password);
                    
                    
                    
                    if (!su.isEmpty()) {
                        for (int i = 0; i < su.size(); i++) {
                            if (su.get(i).getAccess() == 1) {
                                myOutPut = "usercontent.html";
                            }
                            if (su.get(i).getAccess() == 2) {
                                myOutPut = "useradmin.html";
                            }
                            if (su.get(i).getAccess() == 3) {
                                myOutPut = "masterAdmin.html";
                            }
                            if (su.get(i).getAccess() == 4) {
                                myOutPut = "useradmincontent.html";
                            }
                            if (su.get(i).getAccess() == 5) {
                                myOutPut = "index.html";
                            }
                            session.setAttribute("userName", su.get(i).getUsername());
                            session.setAttribute("firstName", su.get(i).getFirstName());
                            session.setAttribute("lastName", su.get(i).getLastName());
                            session.setAttribute("email", su.get(i).getEmail());
                            session.setAttribute("access", su.get(i).getAccess());
                            session.setAttribute("id", su.get(i).getId());
                            session.setAttribute("points", su.get(i).getPoints());
                            session.setAttribute("img", su.get(i).getImg());
                        }
                    } else {
                        myOutPut = "1";
                    }
                    break;
                case "checkSession":
                    String userName = (String) session.getAttribute("userName");
                    String lastName = (String) session.getAttribute("lastName");
                    String firstName = (String) session.getAttribute("firstName");
                    String email = (String) session.getAttribute("email");
                    String img = (String) session.getAttribute("img");
                    int access = (int) session.getAttribute("access");
                    int points = (int) session.getAttribute("points");
                    int id = (int) session.getAttribute("id");

                    ArrayList<SystemUser> sl = new ArrayList<SystemUser>();

                    sl.add(new SystemUser(userName, lastName, firstName, email, access, id, points, img));

                    JSONSerializer serializer = new JSONSerializer();
                    myOutPut2 = serializer.serialize(sl);

                    break;
                case "deleteSession":
                    session.invalidate();
                    break;
                    case "countComments":
            }
            out.println(myOutPut2);
            out.println(myOutPut);
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
