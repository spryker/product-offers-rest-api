<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CategoryGui\Communication\Form;

use Generated\Shared\Transfer\CategoryLocalizedAttributesTransfer;
use Spryker\Zed\Kernel\Communication\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @method \Spryker\Zed\CategoryGui\Communication\CategoryGuiCommunicationFactory getFactory()
 * @method \Spryker\Zed\CategoryGui\CategoryGuiConfig getConfig()
 * @method \Spryker\Zed\CategoryGui\Persistence\CategoryGuiRepositoryInterface getRepository()
 */
class CategoryLocalizedAttributeType extends AbstractType
{
    public const FIELD_NAME = 'name';
    public const FIELD_FK_LOCALE = 'fk_locale';
    public const FIELD_LOCALE_NAME = 'locale_name';
    public const FIELD_META_TITLE = 'meta_title';
    public const FIELD_META_DESCRIPTION = 'meta_description';
    public const FIELD_META_KEYWORDS = 'meta_keywords';
    public const FIELD_CATEGORY_IMAGE_NAME = 'category_image_name';

    protected const OPTION_DATA_CLASS = 'data_class';

    protected const LABEL_META_TITLE = 'Meta Title';
    protected const LABEL_META_DESCRIPTION = 'Meta Description';
    protected const LABEL_META_KEYWORDS = 'Meta Keywords';

    protected const BLOCK_PREFIX = 'localizedAttributes';

    /**
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return static::BLOCK_PREFIX;
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            static::OPTION_DATA_CLASS => CategoryLocalizedAttributesTransfer::class,
        ]);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this
            ->addFkLocaleField($builder)
            ->addLocaleNameField($builder)
            ->addNameField($builder)
            ->addMetaTitleField($builder)
            ->addMetaDescriptionField($builder)
            ->addMetaKeywordsField($builder);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addFkLocaleField(FormBuilderInterface $builder)
    {
        $builder
            ->add(static::FIELD_FK_LOCALE, HiddenType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
                'property_path' => 'locale.idLocale',
            ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addLocaleNameField(FormBuilderInterface $builder)
    {
        $builder
            ->add(static::FIELD_LOCALE_NAME, HiddenType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
                'property_path' => 'locale.localeName',
            ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addNameField(FormBuilderInterface $builder)
    {
        $builder
            ->add(static::FIELD_NAME, TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    $this->getFactory()->createCategoryLocalizedAttributeNameUniqueConstraint(),
                ],
                'required' => false,
            ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addMetaTitleField(FormBuilderInterface $builder)
    {
        $builder
            ->add(static::FIELD_META_TITLE, TextType::class, [
                'label' => static::LABEL_META_TITLE,
                'required' => false,
            ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addMetaDescriptionField(FormBuilderInterface $builder)
    {
        $builder
            ->add(static::FIELD_META_DESCRIPTION, TextareaType::class, [
                'label' => static::LABEL_META_DESCRIPTION,
                'required' => false,
                'attr' => [
                    'rows' => 5,
                ],
            ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addMetaKeywordsField(FormBuilderInterface $builder)
    {
        $builder
            ->add(static::FIELD_META_KEYWORDS, TextareaType::class, [
                'label' => static::LABEL_META_KEYWORDS,
                'required' => false,
            ]);

        return $this;
    }
}
