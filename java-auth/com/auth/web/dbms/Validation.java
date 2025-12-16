package com.auth.web.dbms;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;

public class Validation {
    private static Connection con;

    static {
        try {
            String url = System.getenv("DB_URL");        // e.g. jdbc:mysql://HOST:PORT/DB
            String user = System.getenv("DB_USER");
            String password = System.getenv("DB_PASS");

            con = DriverManager.getConnection(url, user, password);
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    public static boolean loginValidity(String username, String password) {
        String sql = "SELECT COUNT(*) FROM Users WHERE username = ? AND password = ?";
        try (PreparedStatement stmt = con.prepareStatement(sql)) {
            stmt.setString(1, username);
            stmt.setString(2, password);

            try (ResultSet rs = stmt.executeQuery()) {
                if (rs.next() && rs.getInt(1) >= 1) {
                    return true;
                }
            }
        } catch (Exception e) {
            System.out.println("Error validating login: " + e);
        }
        return false;
    }
}