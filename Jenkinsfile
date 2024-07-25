pipeline {
    agent any
    environment {
        DB_CONNECTION = 'sqlite'
        DB_DATABASE = ':memory:'
    }
    stages {
        stage('Build') {
            steps {
                sh 'composer install'
                sh 'npm install'
                sh 'npm run build'
                // and other necessary commands to complete assets
            }
        }
        
        stage('Test') {
            steps {
                sh 'echo "php artisan test"'
            }
        }
        stage('Deploy to production') {
            steps {
                sh 'ssh stellijanos@93.115.53.131 -o StrictHostKeyChecking=no "bash /home/stellijanos/domains/e-shop.stellijanos.com/public_html/scripts/deploy.sh"'
            }
        }
    }

    post {
        failure {
            emailext (
                subject: "Pipeline Failed: ${currentBuild.fullDisplayName}",
                body: "Something is wrong with ${env.JOB_NAME} #${env.BUILD_NUMBER}\nMore info at: ${env.BUILD_URL}",
                recipientProviders: [[$class: 'DevelopersRecipientProvider']],
                to: 'stellijanos23@gmail.com',
                from: 'stellijanos23@gmail.com',
                mimeType: 'text/html'
            ) 
        }
    }
}
