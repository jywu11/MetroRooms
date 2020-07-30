<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Roomtypes Model
 *
 * @property \App\Model\Table\RoomsTable&\Cake\ORM\Association\HasMany $Rooms
 *
 * @method \App\Model\Entity\Roomtype get($primaryKey, $options = [])
 * @method \App\Model\Entity\Roomtype newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Roomtype[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Roomtype|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Roomtype saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Roomtype patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Roomtype[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Roomtype findOrCreate($search, callable $callback = null, $options = [])
 */
class RoomtypesTable extends Table
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

        $this->setTable('roomtypes');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('Rooms', [
            'foreignKey' => 'roomtype_id'
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
            ->scalar('name')
            ->maxLength('name', 30)
            ->allowEmptyString('name')
            ->add('name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

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
        $rules->add($rules->isUnique(['name']));

        return $rules;
    }
}
