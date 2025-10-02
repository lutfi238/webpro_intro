<html>
    <h2>Add New User Account</h2>
    <form action="create_account.php" method="post">
        <table>
            <tr>
                <td>Username:</td>
                <td><input type="email" name="usr" placeholder="use your email" required></td>
            </tr>
            <tr>
                <td>Password:</td>
                <td><input type="password" name="psw" minlength="8" placeholder="min 8 characters"></td>
            </tr>
            <tr>
                <td>Full Name:</td>
                <td><input type="text" name="fname" placeholder="your full name"></td>
            </tr>
            <tr>
                <td>Role:</td>
                <td>
                    <select name="role" id="role" style="width: 100%; padding: 5px;">
                        <option value="">-- choose your role --</option>
                        <option value="admin">Admin</option>
                        <option value="operator">Operator</option>
                        <option value="visitor">Visitor</option>
                    </select>
                </td>
            </tr>
        </table>
        <br>
        <input type="submit" value="Create Account">
    </form>
</html>