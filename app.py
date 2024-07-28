from flask import Flask, render_template, request, redirect, url_for, flash
from flask_login import LoginManager, UserMixin, login_user, login_required, logout_user, current_user
import sqlite3
from werkzeug.security import generate_password_hash, check_password_hash

app = Flask(__name__)
app.config['SECRET_KEY'] = '0000'

login_manager = LoginManager()
login_manager.init_app(app)
login_manager.login_view = 'login'

# Database connection
conn = sqlite3.connect('database.db')
conn.execute('CREATE TABLE IF NOT EXISTS users (id INTEGER PRIMARY KEY, username TEXT, password TEXT)')
conn.execute('CREATE TABLE IF NOT EXISTS content (id INTEGER PRIMARY KEY, content TEXT)')
conn.commit()

# User class for Flask-Login
class User(UserMixin):
    def __init__(self, id):
        self.id = id

@login_manager.user_loader
def load_user(user_id):
    user = conn.execute('SELECT * FROM users WHERE id = ?', (user_id,)).fetchone()
    if user:
        return User(user[0])
    return None

# Routes
@app.route('/')
def home():
    return "Welcome to the Home Page"

@app.route('/login', methods=['GET', 'POST'])
def login():
    if request.method == 'POST':
        username = request.form['username']
        password = request.form['password']
        user = conn.execute('SELECT * FROM users WHERE username = ?', (username,)).fetchone()
        if user and check_password_hash(user[2], password):
            user_obj = User(user[0])
            login_user(user_obj)
            flash('Logged in successfully.', 'success')
            return redirect(url_for('admin_portal'))
        else:
            flash('Invalid username or password.', 'error')
    return render_template('login.html')

@app.route('/logout')
@login_required
def logout():
    logout_user()
    return redirect(url_for('login'))

@app.route('/admin', methods=['GET', 'POST'])
@login_required
def admin_portal():
    if request.method == 'POST':
        content = request.form['content']
        conn.execute('INSERT INTO content (content) VALUES (?)', (content,))
        conn.commit()
        flash('Content updated successfully.', 'success')
    cursor = conn.execute('SELECT * FROM content ORDER BY id DESC LIMIT 1')
    latest_content = cursor.fetchone()[1] if cursor else ''
    return render_template('admin.html', latest_content=latest_content)

if __name__ == '__main__':
    app.run(debug=True)
