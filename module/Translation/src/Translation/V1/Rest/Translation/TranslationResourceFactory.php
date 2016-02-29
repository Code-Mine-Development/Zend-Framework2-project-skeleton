<?php
namespace Translation\V1\Rest\Translation;

class TranslationResourceFactory
{
    public function __invoke($services)
    {
        return new TranslationResource();
    }
}
