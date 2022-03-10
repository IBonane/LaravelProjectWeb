@extends('base')

@section('title', 'Création d\'un match')

@section('content')
<form method="POST" action="{{route('matches.store')}}">
  @csrf
    @if ($errors->any())
        <div class="alert alert-warning">
            Le match n'a pas pu être ajouté &#9785;
        </div>
    @endif

    <div class="form-group">
      <label for="team0">Équipe à domicile</label>
      <select class="form-control" id="team0" name="team0" required>
          @foreach ($teams as $team)
            <option value="{{$team['id']}}" @if(old('team0')==$team['id']) selected @endif>
                {{$team['name']}}
            </option>   
          @endforeach          
      </select>
    </div>

    <div class="form-group">
      <label for="team1">Équipe à l'extérieur</label>
        <select class="form-control" id="team1" name="team1" required>
            @foreach ($teams as $team)
            <option value="{{$team['id']}}" @if(old('team1')==$team['id']) selected @endif>
                {{$team['name']}}
            </option>   
        @endforeach    
      </select>
    </div>

    <div class="form-group">
      <label for="date">Date</label>
      <input type="date" id="date" name="date"
        value="{{ old('date') }}"
        class="form-control @error('date') is-invalid @enderror" required>

      @error('date')
        <div id="date_feedback" class="invalid-feedback">
            {{ $message }}
        </div>
      @enderror
    </div>

    <div class="form-group">
      <label for="time">Heure</label>
      <input type="time" id="time" name="time"
        value="{{ old('time') }}"
        class="form-control @error('time') is-invalid @enderror" required>

      @error('time')
        <div id="time_feedback" class="invalid-feedback">
            {{ $message }}
        </div>
      @enderror
    </div>

    <div class="form-group">
      <label for="score0">Nombre de buts de l'équipe à domicile</label>
      <input type="number" id="score0" name="score0" min="0" 
        value="{{ old('score0') }}"
        class="form-control @error('score0') is-invalid @enderror" required>

      @error('score0')
        <div id="score0_feedback" class="invalid-feedback">
            {{ $message }}
        </div>
      @enderror
      
    </div>
    <div class="form-group">
      <label for="score1">Nombre de buts de l'équipe à l'extérieur</label>
      <input type="number" id="score1" name="score1" min="0" 
        value="{{ old('score1') }}"
        class="form-control @error('score1') is-invalid @enderror" required>

      @error('score1')
        <div id="score1_feedback" class="invalid-feedback">
            {{ $message }}
        </div>
      @enderror
    </div>
    <button type="submit" class="btn btn-primary">Soumettre</button>
</form>
@endsection