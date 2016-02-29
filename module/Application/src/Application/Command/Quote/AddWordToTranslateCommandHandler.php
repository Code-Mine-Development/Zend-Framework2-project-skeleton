<?php

namespace Application\Command\Quote;

use CodeMine\CommandQuery\AbstractCommandHandler;
use CodeMine\CommandQuery\CommandQueryInterface;
use Language\Language;
use Infrastructure\Repository\LanguageRepository;

class AddWordToTranslateCommandHandler extends AbstractCommandHandler
{

    private $repository;

    /**
     * AddWordToTranslateCommandHandler constructor.
     * @param Language $language
     */
    public function __construct(LanguageRepository $repository)
    {
        $this->repository = $repository;
    }

    public function process(CommandQueryInterface $commandInterface)
    {
        /** @var AddWordToTranslateCommand $commandInterface */

        /** @var Language $language */
        $language = $this->repository->findByLanguageCode($commandInterface->languageCode());

        $word        = $commandInterface->word();
        $translation = $commandInterface->translation();

        $language->addTranslation($word, $translation);

        $this->repository->save($language);
    }
}

