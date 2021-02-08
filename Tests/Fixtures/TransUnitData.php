<?php

namespace Lexik\Bundle\TranslationBundle\Tests\Fixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Lexik\Bundle\TranslationBundle\Entity\TransUnit;

/**
 * Tests fixtures class.
 *
 * @author Cédric Girard <c.girard@lexik.fr>
 */
class TransUnitData implements FixtureInterface
{
    /**
     * (non-PHPdoc)
     * @see Doctrine\Common\DataFixtures.FixtureInterface::load()
     */
    public function load(ObjectManager $manager)
    {
        // add files
        $files = array();
        $domains = array(
            'superTranslations' => array('fr', 'en', 'de'),
            'messages'          => array('fr', 'en'),
        );

        foreach ($domains as $name => $locales) {
            foreach ($locales as $locale) {
                $file = $this->createFileInstance($manager);
                $file->setDomain($name);
                $file->setLocale($locale);
                $file->setExtention('yml');
                $file->setPath('Resources/translations');
                $file->setHash(md5(sprintf('Resources/translations/%s.%s.yml', $name, $locale)));

                $manager->persist($file);
                $files[$name][$locale] = $file;
            }
        }

        $manager->flush();

        // add translations for "key.say_hello"
        $transUnit = $this->createTransUnitInstance($manager);
        $transUnit->setKey('key.say_hello');
        $transUnit->setDomain('superTranslations');

        $translations = array(
           'fr' => 'salut',
           'en' => 'hello',
           'de' => 'heil',
        );

        foreach ($translations as $locale => $content) {
            $translation = $this->createTranslationInstance($manager);
            $translation->setLocale($locale);
            $translation->setContent($content);
            $translation->setFile($files['superTranslations'][$locale]);

            $transUnit->addTranslation($translation);
        }

        $manager->persist($transUnit);
        $manager->flush();

        // add translations for "key.say_goodbye"
        $transUnit = $this->createTransUnitInstance($manager);
        $transUnit->setKey('key.say_goodbye');

        $translations = array(
            'fr' => 'au revoir',
            'en' => 'goodbye',
        );

        foreach ($translations as $locale => $content) {
            $translation = $this->createTranslationInstance($manager);
            $translation->setLocale($locale);
            $translation->setContent($content);
            $translation->setFile($files['messages'][$locale]);

            $transUnit->addTranslation($translation);
        }

        $manager->persist($transUnit);
        $manager->flush();

        // add translations for "key.say_wtf"
        $transUnit = $this->createTransUnitInstance($manager);
        $transUnit->setKey('key.say_wtf');

        $translations = array(
            'fr' => 'c\'est quoi ce bordel !?!',
            'en' => 'what the fuck !?!',
        );

        foreach ($translations as $locale => $content) {
            $translation = $this->createTranslationInstance($manager);
            $translation->setLocale($locale);
            $translation->setContent($content);
            $translation->setFile($files['messages'][$locale]);

            $transUnit->addTranslation($translation);
        }

        $manager->persist($transUnit);
        $manager->flush();
    }

    /**
     * Create the right TransUnit instance.
     *
     * @param ObjectManager $manager
     * @return TransUnit|null
     */
    protected function createTransUnitInstance(ObjectManager $manager): ?TransUnit
    {
        $instance = null;

        if ($manager instanceof \Doctrine\ORM\EntityManager) {
            $instance = new TransUnit();
        }

        return $instance;
    }

    /**
     * Create the right Translation instance.
     *
     * @param ObjectManager $manager
     * @return \Lexik\Bundle\TranslationBundle\Entity\Translation|null
     */
    protected function createTranslationInstance(ObjectManager $manager): ?\Lexik\Bundle\TranslationBundle\Entity\Translation
    {
        $instance = null;

        if ($manager instanceof \Doctrine\ORM\EntityManager) {
            $instance = new \Lexik\Bundle\TranslationBundle\Entity\Translation();
        }

        return $instance;
    }

    /**
     * Create the right File instance.
     *
     * @param ObjectManager $manager
     * @return \Lexik\Bundle\TranslationBundle\Entity\File|null
     */
    protected function createFileInstance(ObjectManager $manager): ?\Lexik\Bundle\TranslationBundle\Entity\File
    {
        $instance = null;

        if ($manager instanceof \Doctrine\ORM\EntityManager) {
            $instance = new \Lexik\Bundle\TranslationBundle\Entity\File();
        }

        return $instance;
    }
}
