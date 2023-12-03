<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form method="POST" action="{{ route('login_admin') }}" class="log-in" autocomplete="off">
        @csrf`
        <input 
            placeholder="Email" 
            type="text" name="email" 
            id="email" autocomplete="off"
            onfocus="this.placeholder = ''"
            :value="old('email')"
            onblur="this.placeholder = 'email'"
            required >
        <label for="email">Email:</label>
    
        <input 
            placeholder="Password" type="password" 
            name="password" id="password" 
            autocomplete="off"
            onfocus="this.placeholder = ''"
            onblur="this.placeholder = 'Password'"
            required
            autocomplete="current-password" >
        <label for="password">Password:</label>
    
        <button type="submit">Log in</button>
    </form>
</body>
</html>