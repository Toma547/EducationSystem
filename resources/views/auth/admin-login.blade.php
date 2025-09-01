
<form method="POST" action="{{ route('admin.login') }}">
    @csrf
    <div>
        <label>Email</label>
        <input type="email" name="email" required autofocus>
    </div>
    <div>
        <label>Password</label>
        <input type="password" name="password" required>
    </div>
    <div>
        <button type="submit">管理者ログイン</button>
    </div>
</form>
