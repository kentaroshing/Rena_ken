<div class="container fade-in">
    <h1>Add Student</h1>
    <form method="post" action="<?= site_url('students/create') ?>">
        <label for="first_name">First Name</label>
        <input type="text" id="first_name" name="first_name" required>

        <label for="last_name">Last Name</label>
        <input type="text" id="last_name" name="last_name" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>

        <button type="submit">Save</button>
    </form>
    <a href="<?= site_url('/') ?>" class="back-link">← Back to List</a>
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
input[type="email"] {
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
input[type="email"]:focus {
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

a.back-link {
    display: block;
    margin-top: 25px;
    text-align: center;
    color: #4caf50;
    font-weight: 600;
    text-decoration: none;
    font-size: 1rem;
    transition: color 0.3s ease;
}

a.back-link:hover {
    color: #2e7d32;
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
