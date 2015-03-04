<?php

namespace HatueyERP\TercerosBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class TerceroControllerTest extends WebTestCase
{

    public function testListView()
    {
        $client = static::createClient(array(), array(
                'PHP_AUTH_USER' => 'admin',
                'PHP_AUTH_PW'   => 'adminpass',
            ));

        $client->request('GET', '/tercero/');

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function testNewTercero()
    {
        // create entity manager mock
        //$entityManagerMock = $this->getEntityManagerMock();

        // now you can get some assertions if you want, eg.:
        //$entityManagerMock->expects($this->once())
        //    ->method('flush');

        // create fos user manager mock
        $fosUserManagerMock = $this->getMockBuilder('FOS\UserBundle\Doctrine\UserManager')
            ->disableOriginalConstructor()
            ->getMock();

        // next you need inject your mocked em into client's service container
        $client = static::createClient(array(), array(
                'PHP_AUTH_USER' => 'admin',
                'PHP_AUTH_PW'   => 'adminpass',
            ));
        //$client->getContainer()->set('doctrine.orm.default_entity_manager', $entityManagerMock);
        $client->getContainer()->set('fos_user.user_manager', $fosUserManagerMock);

        $crawler = $client->request('GET', '/tercero/new');

        $this->assertTrue($client->getResponse()->isSuccessful());

        $form = $crawler->selectButton('Aceptar')->form(array(
                'hatueyerp_tercerosbundle_tercero' => array(
                    'identificador' => 'nuevo identificador',
                    'nombres' => 'nuevo nombre',
                    'apellidos' => 'apellidos',
                    'nombre_comercial' => 'nombre comercial',
                    'nombre_fiscal' => 'nombre fiscal',
                    'cif_nif' => '878787',
                    'descripcion' => 'descripcion'
                )));

        // enviando los datos del formulario
        $client->submit($form);

        // comprobando que sea una peticion de redireccion
        $this->assertTrue($client->getResponse()->isRedirect());

        $crawler = $client->followRedirect();
        // comprobando que la vista "show" sea mostrada correctamente
        $this->assertTrue($client->getResponse()->isSuccessful());

        // Check data in the show view
        $this->assertGreaterThan(0, $crawler->filter('th:contains("Identificador")')->count(), 'Missing element th:contains("Identificador")');

        // Edit the entity
        $crawler = $client->click($crawler->selectLink('Editar')->link());

        $this->assertTrue($client->getResponse()->isSuccessful());

        $form = $crawler->selectButton('Aceptar')->form(array(
                'hatueyerp_tercerosbundle_tercero' => array(
                    'identificador' => 'nuevo identificador editado',
                    'nombres' => 'nuevo nombre editado',
                    'apellidos' => 'apellidos editado',
                    'nombre_comercial' => 'nombre comercial editado',
                    'nombre_fiscal' => 'nombre fiscal editado',
                    'cif_nif' => '878787',
                    'descripcion' => 'descripcion editado'
                )));

        $client->submit($form);

        $this->assertTrue($client->getResponse()->isRedirect());

        $crawler = $client->followRedirect();

        // Check the element contains an attribute with value equals "Foo"
        $this->assertGreaterThan(0, $crawler->filter('th:contains("Identificador")')->count(), 'Missing element th:contains("Identificador")');

        // Delete the entity
        $client->submit($crawler->selectButton('Eliminar')->form());

        $this->assertTrue($client->getResponse()->isRedirect());

        $crawler = $client->followRedirect();

        $this->assertTrue($client->getResponse()->isSuccessful());
        // Check the entity has been delete on the list

        //$this->assertNotRegExp('/Foo/', $client->getResponse()->getContent());
    }

    protected function getEntityManagerMock()
    {
        $entityManagerMock = $this->getMockBuilder('Doctrine\ORM\EntityManager')
            ->setMethods(array('persist', 'flush', 'getConfiguration'))
            ->disableOriginalConstructor()
            ->getMock();

        $entityManagerConfigurationMock = $this->getMockBuilder('Doctrine\ORM\Configuration')
            ->setMethods(array('getEntityNamespace'))
            ->disableOriginalConstructor()
            ->getMock();

        $entityManagerMock->expects($this->any())
            ->method('getConfiguration')
            ->will($this->returnValue($entityManagerConfigurationMock));

        return $entityManagerMock;
    }

    /*
    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient();

        // Create a new entry in the database
        $crawler = $client->request('GET', '/tercero/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /tercero/");
        $crawler = $client->click($crawler->selectLink('Create a new entry')->link());

        // Fill in the form and submit it
        $form = $crawler->selectButton('Create')->form(array(
            'hatueyerp_tercerosbundle_tercerotype[field_name]'  => 'Test',
            // ... other fields to fill
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertGreaterThan(0, $crawler->filter('td:contains("Test")')->count(), 'Missing element td:contains("Test")');

        // Edit the entity
        $crawler = $client->click($crawler->selectLink('Edit')->link());

        $form = $crawler->selectButton('Edit')->form(array(
            'hatueyerp_tercerosbundle_tercerotype[field_name]'  => 'Foo',
            // ... other fields to fill
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check the element contains an attribute with value equals "Foo"
        $this->assertGreaterThan(0, $crawler->filter('[value="Foo"]')->count(), 'Missing element [value="Foo"]');

        // Delete the entity
        $client->submit($crawler->selectButton('Delete')->form());
        $crawler = $client->followRedirect();

        // Check the entity has been delete on the list
        $this->assertNotRegExp('/Foo/', $client->getResponse()->getContent());
    }

    */
}
