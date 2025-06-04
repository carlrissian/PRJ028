pipeline {
     agent any

     environment {
         PRE_PROD_URL = "/var/www/${env.JOB_NAME}"
     }

    stages {
        stage('Build') {
            steps{
                sh 'composer install'
                sh 'yarn install'
                sh 'yarn js-routing'
                sh 'yarn dev'
            }
        }

        stage('Deploy on Pre') {
            steps{
                sh "sudo rsync -a --delete ${env.WORKSPACE}/ ${PRE_PROD_URL}"
                sh "sudo chmod -R 775 ${PRE_PROD_URL}"
                sh "sudo chown -R www-data:www-data ${PRE_PROD_URL}"
            }
        }
    }
}
