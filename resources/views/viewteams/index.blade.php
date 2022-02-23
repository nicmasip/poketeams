@extends('base.baseGeneral')

@section('main-content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card p-4">
                <div class="card-header">
                    <p class="h3">View Teams</p>
                    <p>On this page you can search and view different users' teams.</p>
                </div>
                <div class="card-body">
                  <div class="form-group mb-3">
                    <label for="user">User</label>
                    <select id="userSelect" name="user" class="form-control">
                      <option value="" disabled selected>&nbsp;</option>
                      @foreach($users as $user)
                          <option value="{{ $user->id }}" >{{ $user->name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group mb-3">
                    <label for="team">Team</label>
                    <select id="teamSelect" name="team" class="form-control">
                      <option value="" disabled selected>&nbsp;</option>
                    </select>
                  </div>
                  <a id="btViewTeam" class="mt-3 btn btn-primary">View team</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
  <script>
    let userSelect = document.getElementById('userSelect');
    let teamSelect = document.getElementById('teamSelect');
    let btViewTeam = document.getElementById('btViewTeam');

    userSelect.addEventListener('change', function(){
        llamadaAjaxUserSelect();
    });
    
    $('#teamSelect').change(function(){
        let teamSelectValue = $(this).val();
        btViewTeam.href = 'viewteams/showteam/' + teamSelectValue;
    });

    function llamadaAjaxUserSelect(){
        let userSelectValue = $('#userSelect').val();
        let url="viewteams/selectteam?iduser=" + userSelectValue;
        fetch(url)
        .then(function(response){
            return response.json();
        }).then(function(jsonData){
            let teamsOfUser = jsonData.teams;
            teamSelect.innerHTML = '<option value="" disabled selected>&nbsp;</option>';
            teamsOfUser.forEach(function(element) {
                teamSelect.innerHTML+= '<option value="' + element.id + '">' + element.name + '</option>';
            });
        }).catch(function(){
            alert('error');
        });
    }
  </script>
@endsection