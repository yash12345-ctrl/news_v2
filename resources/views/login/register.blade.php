@extends('layout/login-layout')

@section('title','REGISTRATION FORM')

@section('container')

<div class="container ">
    <div class="row">
        <div class="col-md-4 offset-md-4">
            <form action="{{route('user.store')}}" method="POST">
                @csrf
                <h1 class="text-center">Register</h1>
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" name="name" placeholder="Name" class="form-control">
                    @error('name')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Username</label>
                    <input type="text" name="username" placeholder="Username" class="form-control">
                    @error('username')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="email" name="email" placeholder="Email" class="form-control">
                    @error('email')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Password</label>
                    <input type="password" name="password" placeholder="Password" class="form-control">
                    @error('password')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Confirm Password</label>
                    <input type="password" name="cpassword" placeholder="Confirm Password" class="form-control">
                    @error('cpassword')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group my-2">
                    <input type="submit" name="register" class="form-control btn btn-success" value="Register">
                </div>
                <div class="form-group my-2">
                    Already have a account <span><a href="{{ route('login')}}">Login</a></span>
                </div>
            </form>
        </div>
    </div>
</div>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgi
wxhTBTkF7CXvN" crossorigin="anonymous"></script>

<script>

</script>


</body>

</html>