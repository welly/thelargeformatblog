<?php

abstract class BaseMigration extends Migration {

    public function __construct($arguments) {
        parent::__construct($arguments);

        $this->team = array(
            new MigrateTeamMember('Alastair Moore', 'moore.alastair@gmail.com', t('Developer')),
        );
    }

    public function getConnection($connection = 'legacy') {
        return Database::getConnection('default', $connection);
    }
}
