<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{

    #test the h1 of the register page
    public function testTitle()
    {
        $client = static::createClient();
        $client->request('GET', '/register');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Register');
    }

    #test the h1 of the login page
    public function testTitleLogin()
    {
        $client = static::createClient();
        $client->request('GET', '/login');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Login');
    }

   /* # test the registration of the user
    public function testRegister()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');
        $form = $crawler->selectButton('Register')->form();
        $form['registration_form[email]'] = 'mmooommoxoc';
        $form['registration_form[plainPassword]'] = 'mmooommoxoc';
        $form['registration_form[firstName]'] = 'mmooommoxoc';
        $form['registration_form[lastName]'] = 'mmooommoxoc';

        $client->submit($form);
        $this->assertResponseRedirects();
        $client->followRedirect();
    }

    #test the connection of the user
    public function testLogin()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('Sign in')->form();
        $form['_login_form[email]'] = 'mmooommoxoc';
        $form['_login_form[password]'] = 'mmooommoxoc';
        $crawler = $client->submit($form);
        $this->assertResponseRedirects();
        $client->followRedirect();

    }*/
}

