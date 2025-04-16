<?php

<<<<<<< HEAD
it('returns a successful response', function () {
=======
test('the application returns a successful response', function () {
>>>>>>> bd971a9342d9c63fc1237aef34d2fed2f4dbaf76
    $response = $this->get('/');

    $response->assertStatus(200);
});
