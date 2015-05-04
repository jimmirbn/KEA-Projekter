/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package gadgets;

import Monday.SystemUser;
import Monday.SystemUserHandler;
import flexjson.JSONSerializer;
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
@WebServlet(name = "SubServlet", urlPatterns = {"/SubServlet"})
public class SubServlet extends HttpServlet {

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
            String myOutput4;
            myOutput4 = "";

            switch (request.getParameter("type")) {

                case "getCategories":
                    String type = request.getParameter("categoryType");
                    ArrayList<SystemGadget> sg = SystemGadgetHandler.getAllSubjects(type);
                    JSONSerializer serializer = new JSONSerializer();
                    myOutput = serializer.serialize(sg);
                    break;

                case "createCategory":
                    String categoryName = request.getParameter("categoryName");
                    String categoryIcon = request.getParameter("categoryIcon");
                    SystemGadgetHandler.createCategory(categoryName, categoryIcon);
                    break;

                case "getComment":
                    int id = Integer.parseInt(request.getParameter("id"));
                    ArrayList<SystemGadget> sg2 = SystemGadgetHandler.getComment(id);
                    JSONSerializer serializer2 = new JSONSerializer();
                    myOutput2 = serializer2.serialize(sg2);
                    break;

                case "getSubject":
                    int id2 = Integer.parseInt(request.getParameter("id"));
                    ArrayList<SystemGadget> sg3 = SystemGadgetHandler.getSubject(id2);
                    JSONSerializer serializer3 = new JSONSerializer();
                    myOutput3 = serializer3.serialize(sg3);
                    break;

                case "createSubject":
                    String Subject = request.getParameter("subject");
                    String GadgetType = request.getParameter("typeGadget");
                    String userName = (String) session.getAttribute("userName");
                    SystemGadgetHandler.CreateSubject(Subject, GadgetType, userName);
                    break;

                case "createComment":
                    int subID = Integer.parseInt(request.getParameter("subID"));
                    String Comment = request.getParameter("comment");
                    String userName2 = (String) session.getAttribute("userName");
                    int userid = (int) session.getAttribute("id");
                    SystemGadgetHandler.CreateComment(Comment, userName2, subID, userid);
                    break;

                case "deleteComment":
                    int id3 = Integer.parseInt(request.getParameter("id"));
                    SystemGadgetHandler.DeleteComment(id3);
                    break;

                case "getCategory":
                    ArrayList<SystemGadget> gc = SystemGadgetHandler.getAllCategories();
                    JSONSerializer serializer4 = new JSONSerializer();
                    myOutput3 = serializer4.serialize(gc);
                    break;
            }
            out.println(myOutput);
            out.println(myOutput2);
            out.println(myOutput3);
            out.println(myOutput4);

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
