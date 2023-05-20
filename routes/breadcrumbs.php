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

Breadcrumbs::for('koordinator', function (BreadcrumbTrail $trail) {
    $trail->push('Koordinator',route('koordinator_myproject'));
});

Breadcrumbs::for('koordinator_detail', function (BreadcrumbTrail $trail, $krs) {
    $trail->parent('koordinator');
    $trail->push('Koordinator_detail',route('koordinator_myproject_detail',$krs));
});

Breadcrumbs::for('pengguna', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Manajemen Pengguna', route('users.index'));
});

Breadcrumbs::for('mhsInterest', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Manajemen Mahasiswa Interest', route('mhsInterest.index'));
});

// Breadcrumbs::for('koordinator_proyek', function (BreadcrumbTrail $trail) {
//     $trail->parent('home');
//     $trail->push('koordinator proyek index', route('koordinator_myproject'));
// });

Breadcrumbs::for('jadwal', function ($trail) {
    $trail->push('Jadwal', route('jadwal.index'));
});
