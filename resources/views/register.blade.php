@extends('base')

@section('title', "Création d'un nouveau compte")

@section('content')
  <form method="POST" action="{{route('register.post')}}">
    @csrf
      @if ($errors->any())
          <div class="alert alert-warning">
            Vous n'avez pas pu être inscrire &#9785;
          </div>
      @endif
      <div class="form-group">
        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" value="{{old('email')}}"
              aria-describedby="email_feedback" class="form-control @error('email') is-invalid @enderror"> 
        @error('email')
        <div id="email_feedback" class="invalid-feedback">
          {{ $message }}
        </div>
        @enderror
      </div>

      <div class="form-group">
        <label for="password">Mot de passe</label>
        <input type="password" id="password" name="password" value="{{old('password')}}"
              aria-describedby="password_feedback" class="form-control @error('password') is-invalid @enderror">  
        @error('password')
        <div id="password_feedback" class="invalid-feedback">
          {{ $message }}
        </div>
        @enderror
      </div>

      <div class="form-group">
        <label for="password_confirm">Saisir à nouveau le mot de passe</label>
        <input type="password" id="password_confirm" name="password_confirm"
              aria-describedby="password_feedback" class="form-control @error('password_confirm') is-invalid @enderror">  
        @error('password_confirm')
        <div id="password_feedback" class="invalid-feedback">
          {{ $message }}
        </div>
        @enderror
      </div>

      <button type="submit" class="btn btn-primary">S'inscrire</button>
  </form>
  <br>
  <a class="success" href="{{route('register')}}">Se connecter, si vous avez déjà un compte</a>
  
@endsection