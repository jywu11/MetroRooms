<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Frontcontents Model
 *
 * @method \App\Model\Entity\Frontcontent get($primaryKey, $options = [])
 * @method \App\Model\Entity\Frontcontent newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Frontcontent[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Frontcontent|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Frontcontent saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Frontcontent patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Frontcontent[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Frontcontent findOrCreate($search, callable $callback = null, $options = [])
 */
class FrontcontentsTable extends Table
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

        $this->setTable('frontcontents');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
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
            ->scalar('top_foot_logo')
            ->maxLength('top_foot_logo', 1000)
            ->allowEmptyString('top_foot_logo');

        $validator
            ->scalar('banner_image')
            ->maxLength('banner_image', 1000)
            ->allowEmptyFile('banner_image');

        $validator
            ->scalar('banner_title')
            ->maxLength('banner_title', 50)
            ->allowEmptyString('banner_title');

        $validator
            ->scalar('home_service_title')
            ->maxLength('home_service_title', 50)
            ->allowEmptyString('home_service_title');

        $validator
            ->scalar('home_service_desc')
            ->maxLength('home_service_desc', 1000)
            ->requirePresence('home_service_desc', 'create')
            ->allowEmptyString('home_service_desc');

        $validator
            ->scalar('home_service_entry1')
            ->maxLength('home_service_entry1', 300)
            ->allowEmptyString('home_service_entry1');

        $validator
            ->scalar('home_service_entry2')
            ->maxLength('home_service_entry2', 300)
            ->allowEmptyString('home_service_entry2');

        $validator
            ->scalar('home_service_entry3')
            ->maxLength('home_service_entry3', 300)
            ->allowEmptyString('home_service_entry3');

        $validator
            ->scalar('home_service_entry4')
            ->maxLength('home_service_entry4', 300)
            ->allowEmptyString('home_service_entry4');

        $validator
            ->scalar('foot_abt_desc')
            ->maxLength('foot_abt_desc', 300)
            ->allowEmptyString('foot_abt_desc');

        $validator
            ->scalar('abt_title')
            ->maxLength('abt_title', 100)
            ->allowEmptyString('abt_title');

        $validator
            ->scalar('abt_desc')
            ->maxLength('abt_desc', 1000)
            ->allowEmptyString('abt_desc');

        $validator
            ->scalar('abt_person_title')
            ->maxLength('abt_person_title', 50)
            ->allowEmptyString('abt_person_title');

        $validator
            ->scalar('abt_person_image')
            ->maxLength('abt_person_image', 1000)
            ->allowEmptyFile('abt_person_image');

        $validator
            ->scalar('abt_person_name')
            ->maxLength('abt_person_name', 50)
            ->allowEmptyString('abt_person_name');

        $validator
            ->scalar('abt_person_email')
            ->maxLength('abt_person_email', 200)
            ->allowEmptyString('abt_person_email');

        $validator
            ->scalar('abt_person_phone')
            ->maxLength('abt_person_email', 10)
            ->allowEmptyString('abt_person_phone');

        $validator
            ->scalar('abt_person_desc')
            ->maxLength('abt_person_desc', 1000)
            ->allowEmptyString('abt_person_desc');

        $validator
            ->scalar('house_question')
            ->maxLength('house_question', 500)
            ->allowEmptyString('house_question');

        $validator
            ->scalar('house_answer')
            ->maxLength('house_answer', 500)
            ->allowEmptyString('house_answer');

        return $validator;
    }
}
