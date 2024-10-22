# PHP based session - auth

<img src="./assets/imgs/x.png" alt="x" />

```sh
git clone https://github.com/soulaimaneyahya/php-sessions-xlogin.git
cd php-sessions-xlogin
```

Start your local PHP server:

```sh
php -S localhost:8000
```

#### Vulnerable Code

The original implementation contains vulnerabilities related to:

- Cross-Site Request Forgery (CSRF)
- Cross-Site Scripting (XSS)
- Session Hijacking

### Secure Code

This version addresses vulnerabilities by implementing:

- **CSRF Protection:** CSRF tokens are validated and regenerated using $_SESSION['csrf_token'].
- **Output Escaping:** User input is securely handled using htmlspecialchars() to escape output.
- **Tag Removal:** HTML, JavaScript, and PHP tags are removed from input using strip_tags().

#### Csrf form

/xcsrf/x.php
