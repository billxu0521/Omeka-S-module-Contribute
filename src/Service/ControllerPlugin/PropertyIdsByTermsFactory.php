<?php declare(strict_types=1);
namespace Contribute\Service\ControllerPlugin;

use Contribute\Mvc\Controller\Plugin\PropertyIdsByTerms;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class PropertyIdsByTermsFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $services, $requestedName, array $options = null)
    {
        /** @var \Doctrine\DBAL\Connection $connection */
        $connection = $services->get('Omeka\Connection');
        $qb = $connection->createQueryBuilder();
        $qb
            ->select([
                'DISTINCT property.id AS id',
                'CONCAT(vocabulary.prefix, ":", property.local_name) AS term',
            ])
            ->from('property', 'property')
            ->innerJoin('property', 'vocabulary', 'vocabulary', 'property.vocabulary_id = vocabulary.id')
            ->addGroupBy('id')
        ;
        $stmt = $connection->executeQuery($qb);
        // Fetch by key pair is not supported by doctrine 2.0.
        $properties = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $properties = array_column($properties, 'id', 'term');
        return new PropertyIdsByTerms($properties);
    }
}
