<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Properties Model
 *
 * @property \App\Model\Table\TypesTable&\Cake\ORM\Association\BelongsTo $Types
 * @property \App\Model\Table\ApplicationsTable&\Cake\ORM\Association\HasMany $Applications
 * @property \App\Model\Table\BookingsTable&\Cake\ORM\Association\HasMany $Bookings
 * @property \App\Model\Table\PropertiesImagesTable&\Cake\ORM\Association\HasMany $PropertiesImages
 * @property \App\Model\Table\RoomsTable&\Cake\ORM\Association\HasMany $Rooms
 * @property &\Cake\ORM\Association\HasMany $RoomsItems
 * @property \App\Model\Table\FeaturesTable&\Cake\ORM\Association\BelongsToMany $Features
 * @property \App\Model\Table\ItemsTable&\Cake\ORM\Association\BelongsToMany $Items
 *
 * @method \App\Model\Entity\Property get($primaryKey, $options = [])
 * @method \App\Model\Entity\Property newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Property[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Property|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Property saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Property patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Property[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Property findOrCreate($search, callable $callback = null, $options = [])
 */
class PropertiesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('properties');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Types', [
            'foreignKey' => 'type_id'
        ]);
        $this->hasMany('Applications', [
            'foreignKey' => 'property_id'
        ]);
        $this->hasMany('Bookings', [
            'foreignKey' => 'property_id'
        ]);
        $this->hasMany('PropertiesImages', [
            'foreignKey' => 'property_id'
        ]);
        $this->hasMany('Rooms', [
            'foreignKey' => 'property_id'
        ]);
        $this->hasMany('RoomsItems', [
            'foreignKey' => 'property_id'
        ]);
        $this->belongsToMany('Features', [
            'foreignKey' => 'property_id',
            'targetForeignKey' => 'feature_id',
            'joinTable' => 'properties_features'
        ]);
        $this->belongsToMany('Items', [
            'foreignKey' => 'property_id',
            'targetForeignKey' => 'item_id',
            //'joinTable' => 'properties_items',
            'through' => 'PropertiesItems'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('country')
            ->maxLength('country', 200)
            ->notEmptyString('country');

        $validator
            ->scalar('state')
            ->maxLength('state', 3)
            ->notEmptyString('state');

        $validator
            ->scalar('suburb')
            ->maxLength('suburb', 255)
            ->requirePresence('suburb', 'create')
            ->notEmptyString('suburb');

        $validator
            ->scalar('street')
            ->maxLength('street', 200)
            ->requirePresence('street', 'create')
            ->notEmptyString('street');

        $validator
            ->integer('postcode');
            //->requirePresence('postcode', 'create')
            //->notEmptyString('postcode');

        // POSTCODE, CHANGE TO FRONT VALIDATION
        /*$validator->add('postcode', 'postcodeInRange', [
            'rule' => function ($data, $provider) {
                if ($data > 2999 and $data < 4000) {
                    return true;
                }
                return 'Must between 3000 and 3999';
            }
        ]);*/

        $validator
            ->scalar('house_number')
            ->maxLength('house_number', 50)
            ->allowEmptyString('house_number');

        $validator
            ->integer('number_of_bedroom')
            ->requirePresence('number_of_bedroom', 'create')
            ->notEmptyString('number_of_bedroom');

        $validator->add('number_of_bedroom', 'bedroomNumberInRange', [
            'rule' => function ($data, $provider) {
                if ($data >= 0 and $data < 100) {
                    return true;
                }
                return 'Invalid Bedroom Number';
            }
        ]);

        $validator
            ->integer('number_of_bathroom')
            ->requirePresence('number_of_bathroom', 'create')
            ->notEmptyString('number_of_bathroom');

        $validator->add('number_of_bathroom', 'bathroomNumberInRange', [
            'rule' => function ($data, $provider) {
                if ($data >= 0 and $data < 100) {
                    return true;
                }
                return 'Invalid Bathroom Number';
            }
        ]);

        $validator
            ->scalar('general_information')
            ->maxLength('general_information', 5000)
            ->allowEmptyString('general_information');

        $validator
            ->integer('number_of_toilet')
            ->notEmptyString('number_of_toilet');

        $validator->add('number_of_toilet', 'toiletNumberInRange', [
            'rule' => function ($data, $provider) {
                if ($data >= 0 and $data < 100) {
                    return true;
                }
                return 'Invalid Toilet Number';
            }
        ]);

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['type_id'], 'Types'));

        return $rules;
    }
}
