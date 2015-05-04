package Monday;

/**
 *
 * @author Jimmi
 */
public class SystemUser {

    private String username;
    private int id;
    private int access;
    private String password;
    private String Email;
    private String firstName;
    private String lastName;
    private int points;
    private String img;
    private String imgName;
    private Boolean loggedIn = false;
//    private ArrayList<SystemPermission> systemPermissions = new ArrayList<>();

    SystemUser(int id, String username, String password, String email, String firstname, String lastname, int access, int points, String img) {
        this.id = id;
        this.username = username;
        this.password = password;
        this.Email = email;
        this.firstName = firstname;
        this.lastName = lastname;
        this.access = access;
        this.points = points;
        this.img = img;
    }

    SystemUser(int aInt, String username, String password, String email, String firstname, String lastname, int access, int points, String img, boolean b) {
        this.id = aInt;
        this.username = username;
        this.password = password;
        this.Email = email;
        this.firstName = firstname;
        this.lastName = lastname;
        this.access = access;
        this.points = points;
        this.img = img;
    }
    
        public SystemUser(String username, String password, String Email, String firstName, String lastName,int access, String img, String imgName) {
        this.username = username;
        this.access = access;
        this.password = password;
        this.Email = Email;
        this.firstName = firstName;
        this.lastName = lastName;
        this.img = img;
        this.imgName = imgName;
    }
        
    public SystemUser(int id, String Email, String firstName, String lastName) {
        this.id = id;
        this.Email = Email;
        this.firstName = firstName;
        this.lastName = lastName;
    }

    SystemUser(String userName, String lastName, String firstName, String email, int access, int id, int points, String img) {
        this.username = userName;
        this.lastName = lastName;
        this.firstName = firstName;
        this.Email = email;
        this.access = access;
        this.id = id;
        this.points = points;
        this.img = img;
    }
       
    public int getAccess() {
        return access;
    }

    public void setAccess(int access) {
        this.access = access;
    }

//    public void addPermission(SystemPermission p) {
//        this.systemPermissions.add(p);
//    }
    public String getImgName() {
        return imgName;
    }

    public void setImgName(String imgName) {
        this.imgName = imgName;
    }
    
    public String getImg() {
        return img;
    }

    public void setImg(String img) {
        this.img = img;
    }

    public int getPoints() {
        return points;
    }

    public void setPoints(int points) {
        this.points = points;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getUsername() {
        return username;
    }

    public void setUsername(String username) {
        this.username = username;
    }

    public String getPassword() {
        return password;
    }

    public void setPassword(String password) {
        this.password = password;
    }

    public String getEmail() {
        return Email;
    }

    public void setEmail(String Email) {
        this.Email = Email;
    }

    public String getFirstName() {
        return firstName;
    }

    public void setFirstName(String firstName) {
        this.firstName = firstName;
    }

    public String getLastName() {
        return lastName;
    }

    public void setLastName(String lastName) {
        this.lastName = lastName;
    }

    public Boolean isLoggedIn() {
        return loggedIn;
    }

    public void setLoggedIn(Boolean loggedIn) {
        this.loggedIn = loggedIn;
    }
    
}
