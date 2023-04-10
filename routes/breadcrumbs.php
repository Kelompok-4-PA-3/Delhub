<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Homede
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('dashboard'));
});

Breadcrumbs::for('pengguna', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Manajemen Pengguna', route('users.index'));
});

Breadcrumbs::for('mhsInterest', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Manajemen Mahasiswa Interest', route('mhsInterest.index'));
});

Breadcrumbs::for('jadwal', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Jadwal', route('jadwal.index'));
});
