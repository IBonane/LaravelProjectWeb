@extends('base')

@section('title', 'change password')

@section('content')
  <form method="POST" action="{{route('changepassword.post')}}">
    @csrf
      @if ($errors->any())
          <div class="alert alert-warning">
            Vous n'avez pas pu changer de mot de passe &#9785;
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
        <label for="oldpassword">Ancien mot de passe</label>
        <input type="password" id="oldpassword" name="oldpassword" value="{{old('oldpassword')}}"
              aria-describedby="password_feedback" class="form-control @error('oldpassword') is-invalid @enderror">  
        @error('oldpassword')
        <div id="password_feedback" class="invalid-feedback">
          {{ $message }}
        </div>
        @enderror
      </div>

      <div class="form-group">
        <label for="newpassword">Nouveau mot de passe</label>
        <input type="password" id="newpassword" name="newpassword" value="{{old('newpassword')}}"
              aria-describedby="password_feedback" class="form-control @error('newpassword') is-invalid @enderror">  
        @error('newpassword')
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

      <button type="submit" class="btn btn-primary">Modifier</button>
  </form>
@endsection