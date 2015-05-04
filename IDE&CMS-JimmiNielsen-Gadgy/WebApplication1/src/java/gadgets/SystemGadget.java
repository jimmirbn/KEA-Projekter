/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package gadgets;

/**
 *
 * @author Jimmi
 */
public class SystemGadget {

    private String hovedemne;
    private int id;
    private String typeGadget;
    private String user;
    private String comment;
    private int subject_id;
    private int count;
    private String category;
    private String icon;
    private String commentTime;
    private String Subjectdate;

    SystemGadget(String categoryName, String categoryIcon) {
        this.category = categoryName;
        this.icon = categoryIcon;
    }

    public SystemGadget(String userName2, String comment, int subID, int userid) {
        this.id = userid;
        this.user = userName2;
        this.comment = comment;
        this.subject_id = subID;
    }

    public SystemGadget(String Subject, String GadgetType, String userName) {
        this.hovedemne = Subject;
        this.typeGadget = GadgetType;
        this.user = userName;
    }

    public SystemGadget(String hovedemne, int id, String typeGadget, String user) {
        this.hovedemne = hovedemne;
        this.id = id;
        this.typeGadget = typeGadget;
        this.user = user;
    }

    public SystemGadget(String commentTime, String comment, String user, int subject_id, int id) {
        this.id = id;
        this.user = user;
        this.comment = comment;
        this.subject_id = subject_id;
        this.commentTime = commentTime;
    }

    public SystemGadget(int id, String categoryName, String icon) {
        this.id = id;
        this.category = categoryName;
        this.icon = icon;
    }

    public SystemGadget(String hovedemne, int id, String type, String user, String SubjectDate, int countComment) {
        this.Subjectdate = SubjectDate;
        this.hovedemne = hovedemne;
        this.id = id;
        this.user = user;
        this.count = countComment;
        this.typeGadget = type;  
    }
    
    public int getCount() {
        return count;
    }
    
    public void setCount(int count) {
        this.count = count;
    }

    public String getCommentTime() {
        return commentTime;
    }

    public void setCommentTime(String commentTime) {
        this.commentTime = commentTime;
    }
    
    public SystemGadget (int id){
        this.id = id;
    }
    
    public String getHovedemne() {
        return hovedemne;
    }

    public void setHovedemne(String hovedemne) {
        this.hovedemne = hovedemne;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getTypeGadget() {
        return typeGadget;
    }

    public void setTypeGadget(String typeGadget) {
        this.typeGadget = typeGadget;
    }

    public String getUser() {
        return user;
    }

    public void setUser(String user) {
        this.user = user;
    }

    public String getComment() {
        return comment;
    }

    public void setComment(String comment) {
        this.comment = comment;
    }

    public int getSubject_id() {
        return subject_id;
    }

    public void setSubject_id(int subject_id) {
        this.subject_id = subject_id;
    }
    
    public String getCategory() {
        return category;
    }

    public void setCategory(String category) {
        this.category = category;
    }

    public String getIcon() {
        return icon;
    }

    public void setIcon(String icon) {
        this.icon = icon;
    }

    public String getSubjectdate() {
        return Subjectdate;
    }

    public void setSubjectdate(String Subjectdate) {
        this.Subjectdate = Subjectdate;
    }
}
