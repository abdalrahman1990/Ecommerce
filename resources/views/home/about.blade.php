@extends('layouts.app')
@section('content')
<h3 class="center grey-text text-darken-1">About us</h3>
<div class="container-fluid">
    <br><br>
    <div class="row">
        <div class="col s12 m12 l6 xl6">
            <img src="{{asset('images/about/about1.jpeg')}}" alt="" width="100%">
        </div>
        <div class="col s12 m12 l6 xl6">
        <h4 class="grey-text text-darken-2 tex-uppercase">Our teamwork</h4>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Autem nulla explicabo quidem optio dolorum ea, quae, hic eos delectus eveniet, quis error recusandae rem facere. Quas a sapiente, minus ad culpa esse blanditiis quidem qui voluptates doloremque fugiat magni odit explicabo! Quia soluta quae aliquid voluptate error maxime consectetur harum, optio doloremque dolore dicta similique non saepe eos accusamus porro distinctio? Blanditiis unde eius esse cumque fugiat nisi, assumenda incidunt, quod praesentium nam obcaecati accusamus? Dolores nisi vel entore quia, dolorem impe</p>
        </div>
    </div>
    <div class="row">
        <div class="col s12 m12 l6 xl6">
        <h4 class="grey-text text-darken-2 tex-uppercase">We are one</h4>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Autem nulla explicabo quidem optio dolorum ea, quae, hic eos delectus eveniet, quis error recusandae rem facere. Quas a sapiente, minus ad culpa esse blanditiis quidem qui voluptates doloremque fugiat magni odit explicabo! Quia soluta quae aliquid voluptate error maxime consectetur harum, optio doloremque dolore dicta similique non saepe eos accusamus porro distinctio? Blanditiis unde eius esse cumque fugiatentore quia, dolorem impe</p>
        </div>
        <div class="col s12 m12 l6 xl6">
            <img src="{{asset('images/about/about2.jpeg')}}" alt="" width="100%">
        </div>
    </div>
    <div class="row">
        <div class="col s12 m12 l6 xl6">
            <img src="{{asset('images/about/about3.jpeg')}}" alt="" width="100%">
        </div>
        <div class="col s12 m12 l6 xl6">
        <h4 class="grey-text text-darken-2 tex-uppercase">Our Responsible Team</h4>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Autem nulla explicabo quidem optio dolorum ea, quae, hic eos delectus eveniet, quis error recusandae rem facere. Quas a sapiente, minus ad culpa esse blanditiis quidem qui voluptates doloremque fugiat magni odit explicabo! Quia soluta quae aliquid voluptate error maxime consectetur harum, optio doloremque dolore dicta similique non saepe eos accusamus porro distinctio? Blanditiis unde eius esse cumque fugiat</p>
        </div>
    </div>
    <br><br>
    @component('home.components.contact')
    @endcomponent
</div>
@endsection