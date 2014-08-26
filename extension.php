<?php
// Cookie Consent extension for Bolt

namespace Bolt\Extensions\CookieConsent;

use Bolt\Extensions\Snippets\Location as SnippetLocation;

class Extension extends \Bolt\BaseExtension
{

    /**
     * @var string Extension name
     */
    const NAME = 'CookieConsent';


    public function getName()
    {
        return Extension::NAME;
    }


    function info() {

        $data = array(
            'name' =>"Cookie Consent",
            'description' => "A small extension to add the European Cookie Consent Script to your site.",
            'author' => "Mr Klaatu",
            'link' => "http://santolife.com",
            'version' => "0.1",
            'required_bolt_version' => "1.0",
            'highest_bolt_version' => "2.0",
            'type' => "Snippet",
            'first_releasedate' => "2014-09-01",
            'latest_releasedate' => "2014-09-01",
        );

        return $data;

    }

    function initialize() {

        // Add javascript file...
        $this->addJavascript("assets/jquery.cookiesdirective.min.js");

        // Add the consent script...
        $this->addSnippet(SnippetLocation::END_OF_BODY, 'insertConsent');
    }


    function insertConsent()
    {

        $html = <<< EOM

	<script type="text/javascript">
        $(document).ready(function(){

            $.cookiesDirective({
                privacyPolicyUri: '%privacyUri%',
                explicitConsent: %explicitConsent%,
                position : '%cookieLocation%',
                cookieScripts: '%cookieScripts%',
                backgroundColor: '%backgroundColor%',
                linkColor: '%linkColor%',
                duration: %showTime%
            });
        });
	</script>
EOM;

        $html = str_replace("%privacyUri%", $this->config['privacyUri']?$this->config['privacyUri']:'#', $html);
        $html = str_replace("%explicitConsent%", $this->config['explicitConsent']?$this->config['explicitConsent']:'false', $html);
        $html = str_replace("%cookieLocation%", $this->config['cookieLocation']?$this->config['cookieLocation']:'top', $html);
        $html = str_replace("%cookieScripts%", $this->config['cookieScripts']?$this->config['cookieScripts']:'none', $html);
        $html = str_replace("%backgroundColor%", $this->config['backgroundColor']?$this->config['backgroundColor']:'#52b54a', $html);
        $html = str_replace("%linkColor%", $this->config['linkColor']?$this->config['linkColor']:'#ffffff', $html);
        $html = str_replace("%showTime%", $this->config['showTime']?$this->config['showTime']:10, $html);


        return new \Twig_Markup($html, 'UTF-8');

    }

}
