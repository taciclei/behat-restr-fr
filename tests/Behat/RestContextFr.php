<?php

namespace App\Tests\Behat;

use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behatch\Context\BaseContext;
use Behatch\HttpCall\HttpCallResultPool;
use Behatch\HttpCall\Request;
use Behatch\Json\Json;
use Behatch\Json\JsonInspector;

class RestContextFr extends BaseContext
{
    /**
     * @var Request
     */
    protected $request;

    protected $inspector;

    protected $httpCallResultPool;

    public function __construct(Request $request, HttpCallResultPool $httpCallResultPool, $evaluationMode = 'javascript')
    {
        $this->request = $request;
        $this->inspector = new JsonInspector($evaluationMode);
        $this->httpCallResultPool = $httpCallResultPool;
    }

    /**
     * Sends a HTTP request
     *
     * @Given J'envoie une requête :method à :url
     */
    public function jenvoieUneRequeteA($method, $url, PyStringNode $body = null, $files = [])
    {
        return $this->request->send(
            $method,
            $this->locatePath($url),
            [],
            $files,
            $body !== null ? $body->getRaw() : null
        );
    }

    /**
     * @When J'envoie une demande de :arg1 à :arg2 avec le corps
     */
    public function jenvoieUneDemandeDeAAvecLeCorps($arg1, $arg2, PyStringNode $string)
    {
        return $this->jenvoieUneRequeteA($arg1, $arg2, $string);
    }

    /**
     * Checks, that the response is correct JSON
     *
     * @Then la réponse doit être en JSON
     */
    public function laReponseDoitEtreEnJson()
    {
        $this->getJson();
    }

    /**
     * Checks, that current page response status is equal to specified
     *
     * @Then /^le code d'état de la réponse doit être (?P<code>\d+)$/
     */
    public function leCodeDetatDeLaReponseDoitEtre($code)
    {
        $this->assertSession()->statusCodeEquals($code);
    }

    /**
     * Checks, that given JSON nodes contains values
     *
     * @Then les nœuds JSON doivent contenir:
     */
    public function lesNoeudsJsonDoiventContenir(TableNode $nodes)
    {
        foreach ($nodes->getRowsHash() as $node => $text) {
            $this->leNœudJsonDoitContenir($node, $text);
        }
    }

    /**
     * Checks, that given JSON node contains given value
     *
     * @Then le nœud JSON :node doit contenir :text
     */
    public function leNœudJsonDoitContenir($node, $text)
    {
        $json = $this->getJson();

        $actual = $this->inspector->evaluate($json, $node);

        $this->assertContains($text, (string) $actual);
    }

    /**
     * Checks, whether the header name is equal to given text
     *
     * @Then l'en-tête :name doit être égal à :value
     */
    public function lenTeteDoitEtreEgalA($name, $value)
    {
        $actual = $this->request->getHttpHeader($name);
        $this->assertEquals(strtolower($value), strtolower($actual),
            "The header '$name' should be equal to '$value', but it is: '$actual'"
        );
    }

    /**
     * Ajouter un élément d'en-tête dans une demande
     *
     * @Then J'ajoute l'en-tête :name égal à :value
     */
    public function jajouteLenteteEgalA($name, $value)
    {
        $this->request->setHttpHeader($name, $value);
    }

    /**
     * Sends a HTTP request with a some parameters
     *
     * @Then J'envoie une requête :method à :url avec les paramètres:
     */
    public function jenvoieUneRequeteAAvecLesParametres($method, $url, TableNode $datas)
    {
        $files = [];
        $parameters = [];

        foreach ($datas->getHash() as $row) {
            if (!isset($row['key']) || !isset($row['value'])) {
                throw new \Exception("You must provide a 'key' and 'value' column in your table node.");
            }

            if (is_string($row['value']) && substr($row['value'], 0, 1) == '@') {
                $files[$row['key']] = rtrim($this->getMinkParameter('files_path'), DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.substr($row['value'],1);
            }
            else {
                $parameters[] = sprintf('%s=%s', $row['key'], $row['value']);
            }
        }

        parse_str(implode('&', $parameters), $parameters);
        $response = $this->request->send(
            $method,
            $this->locatePath($url),
            $parameters,
            $files
        );

        return $response;
    }

    protected function getJson()
    {
        return new Json($this->httpCallResultPool->getResult()->getValue());
    }
}
