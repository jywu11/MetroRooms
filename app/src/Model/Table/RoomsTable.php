<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Rooms Model
 *
 * @property \App\Model\Table\PropertiesTable&\Cake\ORM\Association\BelongsTo $Properties
 * @property \App\Model\Table\ApplicationsTable&\Cake\ORM\Association\HasMany $Applications
 * @property \App\Model\Table\BookingsTable&\Cake\ORM\Association\HasMany $Bookings
 * @property \App\Model\Table\PropertiesImagesTable&\Cake\ORM\Association\HasMany $PropertiesImages
 * @property \App\Model\Table\ItemsTable&\Cake\ORM\Association\BelongsToMany $Items
 *
 * @method \App\Model\Entity\Room get($primaryKey, $options = [])
 * @method \App\Model\Entity\Room newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Room[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Room|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Room saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Room patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Room[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Room findOrCreate($search, callable $callback = null, $options = [])
 */
class RoomsTable extends Table
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

        $this->setTable('rooms');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Properties', [
            'foreignKey' => 'property_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Applications', [
            'foreignKey' => 'room_id'
        ]);
        $this->hasMany('Bookings', [
            'foreignKey' => 'room_id'
        ]);
        $this->hasMany('PropertiesImages', [
            'foreignKey' => 'room_id'
        ]);
        $this->belongsToMany('Items', [
            'foreignKey' => 'room_id',
            'targetForeignKey' => 'item_id',
            'joinTable' => 'items_rooms',
            'through' => 'items_rooms'
        ]);

        /*$this->belongsToMany('Beds', [
            'foreignKey' => 'room_id',
            'targetForeignKey' => 'bed_id',
            'joinTable' => 'beds_rooms',
            'through' => 'beds_rooms'
        ]);*/
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
            ->scalar('room_name')
            ->maxLength('room_name', 500);

        $validator
            ->scalar('room_type')
            ->maxLength('room_type', 20)
            ->allowEmptyString('room_type');

       /* $validator
            ->scalar('room_capacity')
            ->notEmptyString('room_capacity');

        $validator->add('room_capacity', 'roomCapInRange', [
            'rule' => function ($data, $provider) {
                if ($data >= 1 and $data < 100) {
                    return true;
                }
                return 'Invalid Room Capacity';
            }
        ]);*/

        $validator
            ->scalar('room_general_information')
            ->maxLength('room_general_information', 5000)
            ->allowEmptyString('room_general_information');

        $validator
            ->date('rental_end_date')
            ->allowEmptyDate('rental_end_date');

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
        $rules->add($rules->existsIn(['property_id'], 'Properties'));

        return $rules;
    }
}
