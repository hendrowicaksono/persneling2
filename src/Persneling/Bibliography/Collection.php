<?php
namespace Slims\Persneling\Bibliography;
use Slims\Models\Bibliography\Biblio as MBib;
use Slims\Models\Masterfile\Publisher as MPub;
use Slims\Models\Masterfile\Language as MLan;
use Slims\Models\Masterfile\Place as MPla;
use Slims\Models\Masterfile\Frequency as MFre;
use Slims\Models\System\User as MUsr;
use Slims\Models\Masterfile\Author as MAut;
use Slims\Models\Masterfile\BiblioAuthor as MMba;
use Slims\Models\Masterfile\Topic as MMto;
use Slims\Models\Masterfile\BiblioTopic as MMbt;
use Slims\Models\Bibliography\Item as MBit;
use Slims\Models\Masterfile\Colltype as MCot;

class Collection
{
  public function __construct()
  {
  }

  public function collection_load($cid = NULL)
  {
    if (is_null($cid)) {
      $_coll = array ();
      $_coll['title'] = NULL;
      $_coll['sor'] = NULL;
      $_coll['edition'] = NULL;
      $_coll['isbn_issn'] = NULL;
      $_coll['publisher'] = NULL;
      $_coll['publish_year'] = NULL;
      $_coll['collation'] = NULL;
      $_coll['series_title'] = NULL;
      $_coll['call_number'] = NULL;
      $_coll['language'] = NULL;
      $_coll['source'] = NULL;
      $_coll['place'] = NULL;
      $_coll['classification'] = NULL;
      $_coll['notes'] = NULL;
      $_coll['image'] = NULL;
      $_coll['file_att'] = NULL;
      $_coll['opac_hide'] = NULL;
      $_coll['promoted'] = NULL;
      $_coll['labels'] = NULL;
      $_coll['frequency_id'] = NULL;
      $_coll['spec_detail_info'] = NULL;
      $_coll['input_date'] = NULL;
      $_coll['uid'] = NULL;
      $_coll['authors'] = NULL;
      $_coll['subjects'] = NULL;
      $_coll['items'] = NULL;
      return (object) $_coll;
    } else {
      echo 'Edit Buku';
    }
  }

  public function collection_save($_coll = array())
  {
    #var_dump($_coll); die('<hr />');
    if (!is_null($_coll->publisher)) {
      $publisher = MPub\PublisherQuery::create()->findOneByPublisher_name($_coll->publisher);
      if (count($publisher) < 1) {
        $publisher = new MPub\Publisher();
        $publisher->setPublisher_name($_coll->publisher);
      }
    }
    if (!is_null($_coll->language)) {
      $language = MLan\LanguageQuery::create()->findOneByLanguage_name($_coll->language);
      #var_dump($language);
      if (count($language) < 1) {
        #echo count($_coll->language);
        $_lid = substr($_coll->language, 0, 5); // returns "d"
        #die('<hr />');
        $language = new MLan\Language();
        $language->setLanguageId($_lid);
        $language->setLanguage_name($_coll->language);
      }
    }
    if (!is_null($_coll->place)) {
      $place = MPla\PlaceQuery::create()->findOneByPlace_name($_coll->place);
      if (count($place) < 1) {
        $place = new MPla\Place();
        $place->setPlace_name($_coll->place);
      }
    }
    if (!is_null($_coll->frequency_id)) {
      $frequency = MFre\FrequencyQuery::create()->findOneByFrequencyId($_coll->frequency_id);
    }
    if (!is_null($_coll->uid)) {
      $user = MUsr\UserQuery::create()->findOneByUserId($_coll->uid);
    }

    $biblio = new MBib\Biblio();
    #$biblio = new \Slims\Models\Biblio();
    if (!is_null($_coll->title)) {
      $biblio->setTitle($_coll->title);
    }
    if (!is_null($_coll->sor)) {
      $biblio->setSor($_coll->sor);
    }
    if (!is_null($_coll->edition)) {
      $biblio->setEdition($_coll->edition);
    }
    if (!is_null($_coll->isbn_issn)) {
      $biblio->setIsbn_issn($_coll->isbn_issn);
    }
    if (!is_null($_coll->publisher)) {
      $biblio->setPublisher($publisher);
    }
    if (!is_null($_coll->publish_year)) {
      $biblio->setPublish_year($_coll->publish_year);
    }
    if (!is_null($_coll->collation)) {
      $biblio->setCollation($_coll->collation);
    }
    if (!is_null($_coll->series_title)) {
      $biblio->setSeries_title($_coll->series_title);
    }
    if (!is_null($_coll->call_number)) {
      $biblio->setCall_number($_coll->call_number);
    }
    if (!is_null($_coll->language)) {
      $biblio->setLanguage($language);
    }
    if (!is_null($_coll->source)) {
      $biblio->setSource($_coll->source);
    }
    if (!is_null($_coll->place)) {
      $biblio->setPlace($place);
    }
    if (!is_null($_coll->classification)) {
      $biblio->setClassification($_coll->classification);
    }
    if (!is_null($_coll->notes)) {
      $biblio->setNotes($_coll->notes);
    }
    if (!is_null($_coll->image)) {
      $biblio->setImage($_coll->image);
    }
    if (!is_null($_coll->file_att)) {
      $biblio->setFile_att($_coll->file_att);
    }
    if (!is_null($_coll->opac_hide)) {
      $biblio->setOpac_hide($_coll->opac_hide);
    }
    if (!is_null($_coll->promoted)) {
      $biblio->setPromoted($_coll->promoted);
    }
    if (!is_null($_coll->labels)) {
      $biblio->setLabels($_coll->labels);
    }

    if (!is_null($_coll->frequency_id)) {
      $biblio->setFrequency($frequency);
    }

    if (!is_null($_coll->spec_detail_info)) {
      $biblio->setSpec_detail_info($_coll->spec_detail_info);
    }
    if (!is_null($_coll->input_date)) {
      $biblio->setInput_date($_coll->input_date);
    }
    $biblio->setLast_update(date("Y-m-d H:i:s"));

    if (!is_null($_coll->uid)) {
      $biblio->setUser($user);
    }

    if (!is_null($_coll->authors)) {
      foreach ($_coll->authors as $_author) {
        $author = MAut\AuthorQuery::create()->findOneByAuthor_name($_author['name']);
        if (count($author) < 1) {
          $author = new MAut\Author();
          $author->setAuthor_name($_author['name']);
        }
        $biblio->addAuthor($author);
      }
    }
    if (!is_null($_coll->subjects)) {
      foreach ($_coll->subjects as $subject) {
        $topic = MMto\TopicQuery::create()->findOneByTopic($subject['name']);
        if (count($topic) < 1) {
          $topic = new MMto\Topic();
          $topic->setTopic($subject['name']);
        }
        $biblio->addTopic($topic);
      }
    }

    if (!is_null($_coll->title)) {
      $biblio->save();

      if (!is_null($_coll->items)) {
        foreach ($_coll->items as $item) {
          $_item = MBit\ItemQuery::create()->findOneByItem_code($item['item_code']);
          if (is_null($_item)) {
            $_item = new MBit\Item();
            $_item->setItem_code($item['item_code']);
            $_item->setBiblio($biblio);

            if (!is_null($item['uid'])) {
              $user = MUsr\UserQuery::create()->findOneByUserId($item['uid']);
              $_item->setUser($user);
            }
            if (!is_null($item['call_number'])) {
              $_item->setCall_number($item['call_number']);
            }
            if (!is_null($item['coll_type_name'])) {
              $colltype = MCot\ColltypeQuery::create()->findOneByColl_type_name($item['coll_type_name']);
              $_item->setColltype($colltype);
            }
            if (!is_null($item['inventory_code'])) {
              $_item->setInventory_code($item['inventory_code']);
            }
            if (!is_null($item['received_date'])) {
              $_item->setReceived_date($item['received_date']);
            }


            $_item->save();
          }
        }
      }


    }
  }


}
