<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/
/*
Broadcast::channel('users.{id}', function ($user, $id) {

  return (int) $user->id === (int) $id;
  
  
});*/


Broadcast::channel('users.{id}', function ($user,$id) {

  return (int) $user->id === (int) $id;
  
});

/*
Broadcast::channel('private-channel-notification', function ($user) {
    return true;
});
*/

Broadcast::channel('permitir-ver-pitch-channel.{toUser}', function ($user,$toUser) {
  return (int) $user->id === (int) $toUser;
});

Broadcast::channel('send-message-channel.{toUser}', function ($user,$toUser) {
  return (int) $user->id === (int) $toUser;
});

Broadcast::channel('abrir-rodada-channel',function(){
  return true;
});

Broadcast::channel('anular-rodada-channel',function(){
  return true;
});
