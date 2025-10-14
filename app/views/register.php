<div class="container fade-in">
    <h1>Register</h1>
    <?php if ($session->flashdata('error')): ?>
        <div style="color: red; margin-bottom: 15px; padding: 10px; border: 1px solid red; border-radius: 5px; background-color: #ffe6e6;">
            <?= $session->flashdata('error') ?>
        </div>
    <?php endif; ?>
    <form method="post" action="<?= site_url('register') ?>">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Register</button>
    </form>
    <p style="text-align: center; margin-top: 20px;">Already have an account? <a href="<?= site_url('login') ?>" style="color: #4caf50;">Login here</a></p>
</div>

<style>
* {
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #e6f2e6; /* pastel green background */
    margin: 0;
    padding: 40px 20px;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    min-height: 100vh;
}

.container {
    background: #ffffff;
    max-width: 420px;
    width: 100%;
    padding: 40px 30px;
    border-radius: 16px;
    box-shadow: 0 8px 24px rgba(0, 128, 0, 0.15);
    transition: box-shadow 0.3s ease;
    animation: fadeInContainer 0.8s ease forwards;
}

.container:hover {
    box-shadow: 0 12px 36px rgba(0, 128, 0, 0.25);
}

h1 {
    color: #2f6f2f; /* dark green */
    font-weight: 700;
    font-size: 2.2rem;
    margin-bottom: 30px;
    text-align: center;
    letter-spacing: 1px;
}

label {
    display: block;
    font-weight: 600;
    color: #4a7d4a; /* medium green */
    margin-bottom: 8px;
    font-size: 1rem;
}

input[type="text"],
input[type="email"],
input[type="password"] {
    width: 100%;
    padding: 14px 16px;
    border: 2px solid #a8d5a8; /* pastel green border */
    border-radius: 12px;
    font-size: 1rem;
    color: #2f4f2f;
    background-color: #f6fcf6;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
    outline-offset: 2px;
}

input[type="text"]:focus,
input[type="email"]:focus,
input[type="password"]:focus {
    border-color: #4caf50; /* brighter green */
    box-shadow: 0 0 8px rgba(76, 175, 80, 0.4);
    background-color: #ffffff;
}

button {
    margin-top: 30px;
    width: 100%;
    padding: 16px 0;
    background: linear-gradient(135deg, #a8d5a8, #4caf50);
    border: none;
    border-radius: 14px;
    color: white;
    font-size: 1.2rem;
    font-weight: 700;
    cursor: pointer;
    box-shadow: 0 6px 12px rgba(76, 175, 80, 0.4);
    transition: background 0.3s ease, box-shadow 0.3s ease;
}

button:hover {
    background: linear-gradient(135deg, #4caf50, #388e3c);
    box-shadow: 0 8px 16px rgba(56, 142, 60, 0.6);
}

p {
    margin-top: 20px;
    text-align: center;
    color: #4a7d4a;
}

a {
    color: #4caf50;
    text-decoration: none;
    font-weight: 600;
}

a:hover {
    text-decoration: underline;
}

@keyframes fadeInContainer {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
