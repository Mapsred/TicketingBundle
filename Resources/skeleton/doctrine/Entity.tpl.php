<?= "<?php\n" ?>

namespace <?= $namespace ?>;

use Doctrine\ORM\Mapping as ORM;
use <?= $parent_namespace ." as Base" .$parent_name.";\n"?>

/**
 * @ORM\Entity(repositoryClass="<?= $repository_full_class_name ?>")
 */
class <?= $class_name ?> extends <?= "Base".$parent_name ."\n"?>
{
}
