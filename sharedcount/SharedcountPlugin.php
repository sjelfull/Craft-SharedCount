<?php

namespace Craft;

class SharedcountPlugin extends BasePlugin {

    function getName()
    {
        return Craft::t('SharedCount');
    }

    function getVersion()
    {
        return '0.1';
    }

    function getDeveloper()
    {
        return 'Fred Carlsen';
    }

    function getDeveloperUrl()
    {
        return 'http://sjelfull.no';
    }

    public function getSettingsHtml()
    {
        return craft()->templates->render('sharedcount/_settings', array(
            'settings' => $this->getSettings()
        ));
    }

    protected function defineSettings()
    {
        return array(
            'apiKey' => array(AttributeType::String, 'label' => 'Sharedcount.com API key'),
        );
    }

}
