<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * News
 *
 * @ORM\Table(name="news", indexes={@ORM\Index(name="fk_news_item1_idx", columns={"item_id_item"})})
 * @ORM\Entity
 */
class News
{
    /**
     * @var string
     *
     * @ORM\Column(name="title_news", type="string", length=45, nullable=false)
     */
    private $titleNews;

    /**
     * @var string
     *
     * @ORM\Column(name="content_news", type="string", length=2000, nullable=false)
     */
    private $contentNews;

    /**
     * @var string
     *
     * @ORM\Column(name="image_news", type="string", length=255, nullable=true)
     */
    private $imageNews;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_news", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idNews;

    /**
     * @var \AppBundle\Entity\Item
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Item")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="item_id_item", referencedColumnName="id")
     * })
     */
    private $itemItem;



    /**
     * Set titleNews
     *
     * @param string $titleNews
     *
     * @return News
     */
    public function setTitleNews($titleNews)
    {
        $this->titleNews = $titleNews;

        return $this;
    }

    /**
     * Get titleNews
     *
     * @return string
     */
    public function getTitleNews()
    {
        return $this->titleNews;
    }

    /**
     * Set contentNews
     *
     * @param string $contentNews
     *
     * @return News
     */
    public function setContentNews($contentNews)
    {
        $this->contentNews = $contentNews;

        return $this;
    }

    /**
     * Get contentNews
     *
     * @return string
     */
    public function getContentNews()
    {
        return $this->contentNews;
    }

    /**
     * Set imageNews
     *
     * @param string $imageNews
     *
     * @return News
     */
    public function setImageNews($imageNews)
    {
        $this->imageNews = $imageNews;

        return $this;
    }

    /**
     * Get imageNews
     *
     * @return string
     */
    public function getImageNews()
    {
        return $this->imageNews;
    }

    /**
     * Get idNews
     *
     * @return integer
     */
    public function getIdNews()
    {
        return $this->idNews;
    }

    /**
     * Set itemItem
     *
     * @param \AppBundle\Entity\Item $itemItem
     *
     * @return News
     */
    public function setItemItem(\AppBundle\Entity\Item $itemItem = null)
    {
        $this->itemItem = $itemItem;

        return $this;
    }

    /**
     * Get itemItem
     *
     * @return \AppBundle\Entity\Item
     */
    public function getItemItem()
    {
        return $this->itemItem;
    }
}
